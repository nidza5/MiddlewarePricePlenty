<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Patagona\Pricemonitor\Core\Infrastructure\ServiceRegister;
use Patagona\Pricemonitor\Core\Sync\TransactionHistory\TransactionHistory;
use Patagona\Pricemonitor\Core\Sync\TransactionHistory\TransactionHistoryMasterFilter;
use Patagona\Pricemonitor\Core\Sync\TransactionHistory\TransactionHistorySortFields;
use Patagona\Pricemonitor\Core\Sync\TransactionHistory\TransactionHistoryType;
use Patagona\Pricemonitor\Core\Sync\TransactionHistory\TransactionHistoryMaster;
use App\Contract;
use App\Repositories\ContractInterface;
use App\Repositories\ContractRepository;
use App\Services\TransactionTransformer;

class TransactionHistoryController extends Controller
{    
    /**
     * The contract repository instance.
     */
    protected $contractRepository;

     /**
     * The transaction transformer instance.
     */
    protected $transactionTransformer;

    public function __construct(ContractRepository $contractRepository,TransactionTransformer $transactionTransformer)
    {
        $this->contractRepository = $contractRepository;
        $this->transactionTransformer = $transactionTransformer;
    }

    public function getTransactionHistory(Request $request)
    {
        $requestData = $request->all();

        if($requestData == null)
            throw new \Exception("Request data are empty!");

        $priceMonitorId = $requestData['pricemonitorId'];
        $masterId = $requestData['masterId'];        
        $type = $requestData['type'] !== null ? $requestData['type'] : config('constants.filterType.EXPORT_PRODUCTS');

        $limit = (int)$requestData['limit'];
        $offset = (int)$requestData['offset'];
        $detailed = $masterId !== null;

        $contract = $this->contractRepository->getContractByPriceMonitorId($priceMonitorId);
        if (!$contract || !$contract->id) {
            throw new \Exception(config('constants.apiResponse.REQUEST_INVALID_CONTRACT_ID'));
        }

        $transactionHistory = new TransactionHistory();

        if ($detailed) {
            $records = $transactionHistory->getTransactionHistoryDetails($priceMonitorId, $masterId, $limit, $offset);
            $total = $transactionHistory->getTransactionHistoryDetailsCount($priceMonitorId, $masterId);
        } else {
            $records = $transactionHistory->getTransactionHistoryMaster($priceMonitorId, $type, $limit, $offset);
            $total = $transactionHistory->getTransactionHistoryMasterCount($priceMonitorId, $type);
        }

        $records =  $this->transactionTransformer->transform($records, $type, $detailed);

        return json_encode(array('records'=>$records,'total'=>$total));
    }
}
