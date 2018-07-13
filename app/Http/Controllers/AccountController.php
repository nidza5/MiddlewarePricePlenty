<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\ConfigInfo;
use App\Repositories\ConfigInfoInterface;
use App\Repositories\ConfigInfoRepository;
use App\Services\AccountService;

class AccountController extends Controller
{
     /**
     * The config info repository instance.
     */
    protected $configInfoRepository;

    protected $accountService;

    public function __construct(ConfigInfoRepository $configInfoRepository,AccountService $accountService)
    {
        $this->configInfoRepository = $configInfoRepository;
        $this->accountService = $accountService;
    }

    public function getAccountInfo()
    {
        $email = $this->configInfoRepository->getConfigInfoValue('email');
        $password = $this->configInfoRepository->getConfigInfoValue('password');
        $transactionsRetentionInterval = $this->configInfoRepository->getConfigInfoValue('transactionsRetentionInterval');
        $transactionDetailsRetentionInterval = $this->configInfoRepository->getConfigInfoValue('transactionDetailsRetentionInterval');
        
        $data = array(
            'userEmail' => $email,
            'userPassword' => $password,
            'transactionsRetentionInterval' => $transactionsRetentionInterval,
            'transactionDetailsRetentionInterval' => $transactionDetailsRetentionInterval
        );   
        
        return $data;
    }

    public function saveAccountInfo(Request $request) 
    {
        $requestData = $request->all();

        if($requestData == null)
            throw new \Exception("Request data are empty!");
        
        $email = $requestData['email'];
        $password = $requestData['password'];
        $transactionsRetentionInterval = $requestData['transactionsRetentionInterval'];
        $transactionDetailsRetentionInterval = $requestData['transactionDetailsRetentionInterval'];

        $this->accountService->saveAccount($email, $password,$transactionsRetentionInterval,$transactionDetailsRetentionInterval);

        return "Account information saved successfully";
    }
}
