<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Patagona\Pricemonitor\Core\Infrastructure\ServiceRegister;
use Patagona\Pricemonitor\Core\Infrastructure\Proxy;
use Patagona\Pricemonitor\Core\Infrastructure\Logger;
use Patagona\Pricemonitor\Core\Sync\Filter\Filter;
use Patagona\Pricemonitor\Core\Sync\Filter\FilterRepository;
use Patagona\Pricemonitor\Core\Sync\Filter\Group;
use Patagona\Pricemonitor\Core\Sync\TransactionHistory\TransactionHistoryType;
use Patagona\Pricemonitor\Core\Sync\Filter\Expression;
use App\Services\CoreServices\HttpResponsePlenty;
use App\Contract;
use App\Repositories\ContractInterface;
use App\Repositories\ContractRepository;
use App\Services\CoreServices\PriceMonitorHttpClient;
use Illuminate\Support\Facades\URL;

class ContractController extends Controller
{
    /**
     * The contract repository instance.
     */
    protected $contractRepository;

    public function __construct(ContractRepository $contractRepository)
    {
        $this->contractRepository = $contractRepository;
    }

    public function login(Request $request)
    {
        $credentials = $request->all();

        $email = $credentials['email'];
        $password = $credentials['password'];

        if(empty($email) || empty($password))
        {
            $errorResponse = [
                'Code' => '500',
                'Message' => 'Email and password fields are requred!'
            ];

            return $errorResponse;
        }

         $proxy = Proxy::createFor($email,$password);      
         $contracts = $proxy->getContracts();

         $this->contractRepository->saveContracts($contracts);

         $originalContracts = $this->contractRepository->getContracts();

         ServiceRegister::getConfigService()->setCredentials($email, $password);
            
         return $originalContracts;
    }

    public function updateContractInfo(Request $request)
    {

        $updateContractInfo =  $this->contractRepository->updateContract($request->all());
      
         $contractInfo = null;

         if(($updateContractInfo != null) && ($updateContractInfo->id != 0) && ($updateContractInfo->id != null))
            $contractInfo = $this->contractRepository->getContractById($updateContractInfo->id);

         return $contractInfo;

    }

    public function testVariationsApi(Request $request)
    {
        $client = new PriceMonitorHttpClient();
        $res =  $client->request(
            'GET',
            'https://bb651d7c4e24ff68347d6ef5fef5623b6d3d8261.plentymarkets-cloud-de.com/rest/priceMonitor/variations'
        );

        return $res->getBody();
    }

    public function testUrl(Request $request)
    {
        return URL::to('/');
    }
}