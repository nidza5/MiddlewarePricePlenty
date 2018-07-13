<?php 

namespace App\Repositories;

use App\Repositories\TransactionHistoryInterface;
use App\TransactionHistory;


class TransactionHistoryRepository implements TransactionHistoryInterface
{
    public function getTransactionHistoryMaster($id,$uniqueIdentifier,$priceMonitorContractId,$type,$limit,$offset)
    {
        $query = TransactionHistory::query();

        if($id !== null)
            $query = $query->where('id', '=', $id);
        
        if($uniqueIdentifier !== null)
            $query = $query->where('uniqueIdentifier', '=', $uniqueIdentifier);
        
        if($priceMonitorContractId !== null)
            $query = $query->where('priceMonitorContractId', '=', $priceMonitorContractId);
        
        if($type !== null)
            $query = $query->where('type', '=', $type);
        
        if($limit !== null && $limit !== 0)
            $query = $query->skip($offset)->take($limit);

        $transactionHistory = $query->get();
        
        return  $transactionHistory;
    }

    public function getTransactionHistoryMasterByPricemonitorIdAndType($priceMonitorContractId,$type)
    {
        $transactionOriginalCollection  = TransactionHistory::where('priceMonitorContractId',$priceMonitorContractId)->where('type',$type)->count();

        return $transactionOriginalCollection != null ? $transactionOriginalCollection : new TransactionHistory;
    }

    public function saveMasterTransaction($id,$uniqueIdentifier,$time,$status,$note,$totalCount,$successCount,$failedCount,$type,$contractId)
    {
       
        $transactionModel = TransactionHistory::where('id', $id)->first();
       
        if($transactionModel === null)
             $transactionModel = new TransactionHistory;

        if($uniqueIdentifier !== null)
             $transactionModel->uniqueIdentifier = $uniqueIdentifier;
            
        if($time !== null)
            $transactionModel->time = $time;      
       
        $transactionModel->status = $status;
        $transactionModel->note = $note;        
        $transactionModel->totalCount = $totalCount;
        $transactionModel->successCount = $successCount;
        $transactionModel->failedCount = $failedCount;
        $transactionModel->type = $type;
        $transactionModel->priceMonitorContractId = $contractId;

        $transactionModel->save();

        return $transactionModel;
    }
}