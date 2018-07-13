<?php

namespace App\Repositories;

use App\TransactionHistory;

interface TransactionHistoryInterface
{
    public function getTransactionHistoryMaster($id,$uniqueIdentifier,$priceMonitorContractId,$type,$limit,$offset);

    public function getTransactionHistoryMasterByPricemonitorIdAndType($priceMonitorContractId,$type);

    public function saveMasterTransaction($id,$uniqueIdentifier,$time,$status,$note,$totalCount,$successCount,$failedCount,$type,$contractId);

}
