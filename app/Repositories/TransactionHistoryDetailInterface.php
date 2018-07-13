<?php

namespace App\Repositories;

use App\TransactionDetails;

interface TransactionHistoryDetailInterface
{
   public function getTransactionHistoryDetails($id,$transactionId,$uniqueIdentifier,$status,$limit,$offet);

   public function getTransactionHistoryDetailsCount($masterId);

   public function saveTransactionDetail($id,$status,$time,$masterId,$masterUniqueIdentifier,$productId,$gtin,$productName,$referencePrice,$minPrice,$maxPrice,$note,$isUpdated);
}
