<?php 

namespace App\Repositories;

use App\Repositories\TransactionHistoryDetailInterface;
use App\TransactionDetails;


class TransactionHistoryDetailRepository implements TransactionHistoryDetailInterface
{
    public function getTransactionHistoryDetails($id,$transactionId,$uniqueIdentifier,$status,$limit,$offet)
    {
        $query = TransactionDetails::query();

        if($id !== null)
            $query = $query->where('id', '=', $id);
        
        if($transactionId !== null)
            $query = $query->where('transactionId', '=', $transactionId);
        
        if($uniqueIdentifier !== null)
            $query = $query->where('transactionUniqueIdentifier', '=', $uniqueIdentifier);
        
        if($status !== null)
            $query = $query->where('status', '=', $status);
        
        if($limit !== null)
            $query = $query->offset($offset)->limit($limit);

        $transactionHistoryDetails = $query->get();

        return $transactionHistoryDetails;
    }

    public function getTransactionHistoryDetailsCount($masterId)
    {
        $transactionDetailsOriginalCollection  = TransactionDetails::where('transactionId',$masterId)->count();

        return $transactionDetailsOriginalCollection != null ? $transactionDetailsOriginalCollection : new TransactionDetails;
    }

    public function saveTransactionDetail($id,$status,$time,$masterId,$masterUniqueIdentifier,$productId,$gtin,$productName,$referencePrice,$minPrice,$maxPrice,$note,$isUpdated)
    {

        $transactionDetailModel = TransactionDetails::where('id', $id)->first();

        if($transactionDetailModel === null)
            $transactionDetailModel = new TransactionDetails;

        if($status !== null)
            $transactionDetailModel->status = $status;
        
        if($time !== null)
            $transactionDetailModel->time = $time;

        $transactionDetailModel->transactionId = $masterId;
        $transactionDetailModel->transactionUniqueIdentifier = $masterUniqueIdentifier;
        $transactionDetailModel->productId = $productId;
        $transactionDetailModel->gtin = $gtin;
        $transactionDetailModel->productName = $productName;
        $transactionDetailModel->referencePrice = $referencePrice;
        $transactionDetailModel->minPrice = $minPrice;
        $transactionDetailModel->maxPrice = $maxPrice;
        $transactionDetailModel->note = $note;
        $transactionDetailModel->isUpdated = $isUpdated;    

        $transactionDetailModel->save();

        return $transactionDetailModel;
    }
}