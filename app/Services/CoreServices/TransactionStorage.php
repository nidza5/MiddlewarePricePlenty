<?php

namespace App\Services\CoreServices;

use Patagona\Pricemonitor\Core\Infrastructure\Logger;
use Patagona\Pricemonitor\Core\Infrastructure\ServiceRegister;
use Patagona\Pricemonitor\Core\Interfaces\LoggerService;
use Patagona\Pricemonitor\Core\Interfaces\TransactionHistoryStorage as TransactionHistoryStorageInterface;
use Patagona\Pricemonitor\Core\Sync\TransactionHistory\TransactionHistoryDetail;
use Patagona\Pricemonitor\Core\Sync\TransactionHistory\TransactionHistoryDetailFilter;
use Patagona\Pricemonitor\Core\Sync\TransactionHistory\TransactionHistoryMaster;
use Patagona\Pricemonitor\Core\Sync\TransactionHistory\TransactionHistoryMasterFilter;
use Patagona\Pricemonitor\Core\Sync\TransactionHistory\TransactionHistorySortFields;
use Patagona\Pricemonitor\Core\Sync\TransactionHistory\TransactionHistoryStorageDTO;
use App\Repositories\TransactionHistoryInterface;
use App\Repositories\TransactionHistoryRepository;
use App\Repositories\TransactionHistoryDetailInterface;
use App\Repositories\TransactionHistoryDetailRepository;
use Mockery\CountValidator\Exception;
use DateTime;

class TransactionStorage implements TransactionHistoryStorageInterface
{

    protected $transactionHistoryRepository;

    protected $transactionHistoryDetailRepository;

    public function __construct()
    {
        $this->transactionHistoryRepository = new TransactionHistoryRepository;
        $this->transactionHistoryDetailRepository = new TransactionHistoryDetailRepository;
    }

    public function getTransactionHistoryMaster(TransactionHistoryMasterFilter $filter)
    {
        $transactionModels = $this->transactionHistoryRepository->getTransactionHistoryMaster($filter->getId(),$filter->getUniqueIdentifier(),$filter->getContractId(),$filter->getType(),$filter->getLimit(),$filter->getOffset());

        return $this->createTransactions($transactionModels);
    }
    
    public function getTransactionHistoryMasterCount($contractId, $type)
    {
        $transactionModelsCount = $this->transactionHistoryRepository->getTransactionHistoryMasterByPricemonitorIdAndType($contractId,$type);

        return $transactionModelsCount;
    }

    public function getTransactionHistoryDetails(TransactionHistoryDetailFilter $filter)
    {
        $transactionDetailModels = $this->transactionHistoryDetailRepository->getTransactionHistoryDetails($filter->getId(),$filter->getMasterId(), $filter->getMasterUniqueIdentifier(),$filter->getStatus(),$filter->getLimit(),$filter->getOffset());

        return $this->createTransactionDetails($transactionDetailModels);
    }

    public function getTransactionHistoryDetailsCount($masterId)
    {
        $transactionDetailModelsCount = $this->transactionHistoryDetailRepository->getTransactionHistoryDetailsCount($masterId);
        return $transactionDetailModelsCount;        
    }

    public function saveTransactionHistory(TransactionHistoryMaster $transactionMaster, $transactionDetails = array())
    {
        try {
            $savedMasterTransaction = null;
           
            $savedMasterTransaction = $this->saveMasterTransaction($transactionMaster);

            $savedTransactionDetails = $this->saveTransactionHistoryDetails($transactionDetails);

            return (new TransactionHistoryStorageDTO($savedMasterTransaction, $savedTransactionDetails));
        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
           // Logger::logError($e->getMessage());
        }
    }

    protected function saveMasterTransaction(TransactionHistoryMaster $transactionHistoryMaster)
    {
        $time = null;

        if ($transactionHistoryMaster->getTime() !== null) {
            $time = $transactionHistoryMaster->getTime()->format('Y-m-d H:i:s');
        }

        $transactionModel =  $this->transactionHistoryRepository->saveMasterTransaction($transactionHistoryMaster->getId(),$transactionHistoryMaster->getUniqueIdentifier(),$time,$transactionHistoryMaster->getStatus(),$transactionHistoryMaster->getNote(),$transactionHistoryMaster->getTotalCount(),$transactionHistoryMaster->getSuccessCount(),$transactionHistoryMaster->getFailedCount(),$transactionHistoryMaster->getType(),$transactionHistoryMaster->getContractId());

        $filter = new TransactionHistoryMasterFilter(
            $transactionModel->priceMonitorContractId,
            $transactionModel->type,
            $transactionModel->id
        );

        $updatedMasterTransactions = $this->getTransactionHistoryMaster($filter);

        if (empty($updatedMasterTransactions[0])) {
           // Logger::logError("Could not update master transaction. ID: {$transactionHistoryMaster->getId()}");
           throw new \Exception('Could not update master transaction. ID: %s', $transactionHistoryMaster->id);
        }

        return $updatedMasterTransactions[0];
    }

    protected function saveTransactionHistoryDetails($transactionHistoryDetails)
    {
        $savedTransactionDetails = array();

        foreach ($transactionHistoryDetails as $transactionDetail) {
            $savedTransactionDetails[] = $this->saveTransactionDetail($transactionDetail);
        }

        return $savedTransactionDetails;
    }

    protected function saveTransactionDetail(TransactionHistoryDetail $transactionDetail)
    {

        $time = null;

        if ($transactionDetail->getTime() !== null) {
            $time = $transactionDetail->getTime()->format('Y-m-d H:i:s');
        }

        
        $transactionDetailModel =  $this->transactionHistoryDetailRepository->saveTransactionDetail($transactionDetail->getId(),$transactionDetail->getStatus(),$time,$transactionDetail->getMasterId(),$transactionDetail->getMasterUniqueIdentifier(),$transactionDetail->getProductId(),$transactionDetail->getGtin(),$transactionDetail->getProductName(),$transactionDetail->getReferencePrice(),$transactionDetail->getMinPrice(),$transactionDetail->getMaxPrice(),$transactionDetail->getNote(),$transactionDetail->isUpdatedInShop());

        $filter = new TransactionHistoryDetailFilter($transactionDetailModel->id);
        $updatedTransactionDetails = $this->getTransactionHistoryDetails($filter);

        if (empty($updatedTransactionDetails[0])) {
           //Logger::logError("Could not update transaction detail. ID: {$transactionDetail->getId()}");
            throw new \Exception('Could not update transaction detail. ID: %s', $transactionDetail->id);
        }

        echo "details na izlazu";
        return $updatedTransactionDetails[0];
    }

    protected function createTransactions($transactions)
    {
        $createdMasterTransactions = array();

        foreach ($transactions as $transaction) {
            $createdMasterTransaction = new TransactionHistoryMaster(
                $transaction->priceMonitorContractId,
                new DateTime($transaction->time),
                $transaction->type,
                $transaction->status,
                $transaction->id,
                $transaction->uniqueIdentifier
            );

            $createdMasterTransaction->setFailedCount((int)$transaction->failedCount);
            $createdMasterTransaction->setTotalCount((int)$transaction->totalCount);
            $createdMasterTransaction->setNote($transaction->note);
            $createdMasterTransaction->setSuccessCount((int)$transaction->successCount);

            $createdMasterTransactions[] = $createdMasterTransaction;
        }

        return $createdMasterTransactions;
    }

    protected function createTransactionDetails($transactionDetailModels)
    {
        $createdTransactionsDetails = array();

        foreach ($transactionDetailModels as $transactionDetail) {
            $createdTransaction = new TransactionHistoryDetail(
                $transactionDetail->status,
                new DateTime($transactionDetail->time),
                $transactionDetail->id,
                $transactionDetail->transactionId,
                $transactionDetail->transactionUniqueIdentifier,
                $transactionDetail->productId,
                $transactionDetail->gtin,
                $transactionDetail->productName,
                $transactionDetail->referencePrice,
                $transactionDetail->minPrice,
                $transactionDetail->maxPrice
            );

            $createdTransaction->setNote($transactionDetail->note);
            $createdTransaction->setUpdatedInShop((bool)$transactionDetail->isUpdated);

            $createdTransactionsDetails[] = $createdTransaction;
        }

        return $createdTransactionsDetails;
    }

    public function cleanupMaster($numberOfDays)
    {
        // $transactionModels = Mage::getModel('pricemonitor/transactionHistory')->getCollection();

        // return $this->cleanUp($numberOfDays, $transactionModels);
    }

    public function cleanupDetails($numberOfDays)
    {
        // $transactionDetailModels = Mage::getModel('pricemonitor/transactionHistoryDetail')->getCollection();

        // return $this->cleanUp($numberOfDays, $transactionDetailModels);
    }

    protected function cleanUp($numberOfDays, $records)
    {
        // $currentDate = new DateTime();
        // $dayText = $numberOfDays === 1 ? 'day' : 'days';
        // $cleanUpDate = $currentDate->modify("-{$numberOfDays} {$dayText}");
        // $records->addFieldToFilter('time', array('lt' => $cleanUpDate->format('Y-m-d H:i:s')));
        // $records->walk('delete');
        // return true;
    }

}