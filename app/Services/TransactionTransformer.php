<?php

namespace App\Services;

use Patagona\Pricemonitor\Core\Sync\TransactionHistory\TransactionHistoryDetail;
use Patagona\Pricemonitor\Core\Sync\TransactionHistory\TransactionHistoryMaster;
use Patagona\Pricemonitor\Core\Sync\TransactionHistory\TransactionHistoryStatus;
use Patagona\Pricemonitor\Core\Sync\TransactionHistory\TransactionHistoryType;

class TransactionTransformer
{
    
    const DATE_FORMAT = 'd-m-Y h:i A';

    /**
     * @var array
     */
    protected static $_statusMap = array(
        null => '',
        TransactionHistoryStatus::FAILED => 'Failed',
        TransactionHistoryStatus::FINISHED => 'Success',
        TransactionHistoryStatus::IN_PROGRESS => 'In Progress',
        TransactionHistoryStatus::FILTERED_OUT => 'Filtered Out',
    );

    public function transformLastAction($transaction, $type)
    {
        if ($type === TransactionHistoryType::EXPORT_PRODUCTS) {
            return $this->transformLastExport($transaction);
        } else {
            return $this->transformLastImport($transaction);
        }
    }

    public function transformLastExport($transaction)
    {
        $status = $transaction !== null ? $this->__(self::$_statusMap[$transaction->getStatus()]) : null;

        return array(
            'exportStart' => $transaction !== null ? $this->formatDate($transaction->getTime()) : null,
            'exportStatus' => $status,
            'exportSuccessCount' => $transaction !== null ? $transaction->getSuccessCount() : null,
        );
    }

    public function transformLastImport($transaction)
    {
        return array(
            'importStart' => $transaction !== null ? $this->formatDate($transaction->getTime()) : null,
            'importSuccessCount' => $transaction !== null ? $transaction->getSuccessCount() : null
        );
    }

    public function transform($data, $type = TransactionHistoryType::EXPORT_PRODUCTS, $detailed = false)
    {
        if ($type === TransactionHistoryType::EXPORT_PRODUCTS) {
            return $this->transformExport($data, $detailed);
        } else {
            return $this->transformImport($data, $detailed);
        }
    }

    protected function transformImport($data, $detailed = false)
    {
        if ($detailed) {
            $result = $this->transformDetailImportData($data);
        } else {
            $result = $this->transformMasterImportData($data);
        }

        return $result;
    }

    protected function transformExport($data, $detailed = false)
    {
        if ($detailed) {
            $result = $this->transformDetailExportData($data);
        } else {
            $result = $this->transformMasterExportData($data);
        }

        return $result;
    }

    protected function transformMasterImportData($data)
    {
        $result = array();

        /** @var TransactionHistoryMaster $record */
        foreach ($data as $record) {
            $status = $this->__(self::$_statusMap[$record->getStatus()]);

            $result[] = array(
                'id' => (int)$record->getId(),
                'importTime' => $this->formatDate($record->getTime()),
                'importedPrices' => (int)$record->getTotalCount(),
                'updatedPrices' => (int)$record->getSuccessCount(),
                'failedCount' => (int)$record->getFailedCount(),
                'inProgress' => $record->getStatus() === TransactionHistoryStatus::IN_PROGRESS,
                'status' => $status,
                'note' => (string)$record->getNote(),
            );
        }

        return $result;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    protected function transformDetailImportData($data)
    {
        $result = array();

        /** @var TransactionHistoryDetail $record */
        foreach ($data as $record) {
            $status = $this->__(self::$_statusMap[$record->status]);
            $isUpdated = $record->isUpdated ? 'Yes' : 'No';

            $result[] = array(
                'status' => $status,
                'gtin' => (string)$record->gtin,
                'name' => (string)$record->productName,
                'isUpdated' => $isUpdated,
                'note' => (string)$record->note
            );
        }

        return $result;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    protected function transformMasterExportData($data)
    {
        $result = array();

        foreach ($data as $record) {
            $status = self::$_statusMap[$record->getStatus()];

            $result[] = array(
                'id' => (int)$record->getId(),
                'exportTime' => $this->formatDate($record->getTime()),
                'successCount' => (int)$record->getSuccessCount(),
                'failedCount' => (int)$record->getFailedCount(),
                'status' => $status,
                'inProgress' => $record->getStatus() === TransactionHistoryStatus::IN_PROGRESS,
                'note' => (string)$record->getNote()
            );
        }

        return $result;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    protected function transformDetailExportData($data)
    {
        $result = array();

        /** @var TransactionHistoryDetail $record */
        foreach ($data as $record) {
            $status = self::$_statusMap[$record->getStatus()];

            $result[] = array(
                'gtin' => (string)$record->getGtin(),
                'name' => (string)$record->getProductName(),
                'refPrice' => $record->getReferencePrice(),
                'minPrice' => $record->getMinPrice(),
                'maxPrice' => $record->getMaxPrice(),
                'status' => $status,
                'note' => (string)$record->getNote()
            );
        }

        return $result;
    }

    /**
     * Formats transaction date to local timezone. All entries in database are in UTC.
     *
     * @param DateTime $date
     *
     * @return string
     */
    protected function formatDate($date)
    {
        $result = '';

        if ($date === null) {
            return $result;
        }

        return date(self::DATE_FORMAT, $date->getTimestamp());
    }

}

?>