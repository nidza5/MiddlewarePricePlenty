<?php

namespace App\Services;

use Patagona\Pricemonitor\Core\Infrastructure\Logger;
use Patagona\Pricemonitor\Core\Infrastructure\Proxy;
use Patagona\Pricemonitor\Core\Infrastructure\ServiceRegister;
use App\AttributeMapping;
use App\Repositories\AttributesMappingInterface;
use App\Repositories\AttributesMappingRepository;
use App\Contract;
use App\Repositories\ContractInterface;
use App\Repositories\ContractRepository;
use App\ProductFilter;
use App\Repositories\ProductFilterInterface;
use App\Repositories\ProductFilterRepository;
use App\Repositories\ConfigInfoInterface;
use App\Repositories\ConfigInfoRepository;

class AccountService
{

    protected $configService;

    protected $attributeMappingRepository;

    protected $contractRepository;

    protected $productFilterRepository;

    protected $configInfoRepository;

    public function __construct()
    {
        $this->configService = ServiceRegister::getConfigService();
        $this->attributeMappingRepository = new AttributesMappingRepository;
        $this->contractRepository = new ContractRepository;
        $this->productFilterRepository = new ProductFilterRepository;
        $this->configInfoRepository = new ConfigInfoRepository;
    }
      
    public function saveAccount($email,$password,$transactionsRetentionInterval,$transactionDetailsRetentionInterval)
    {
        $contracts = $this->getContracts($email,$password);

        if (empty($contracts)) {
            throw new \Exception(config('constants.apiResponse.AUTHORIZATION_INVALID_CREDENTIALS'));
        }

        $savedCredentials = $this->configService->getCredentials();

        try {
         
            // Clears all the tables, except transaction history, because new user is logged in
            if ($email !== $savedCredentials['email']) {
                $this->clearAll();
                $this->contractRepository->saveContracts($contracts);
            }

            $this->configService->setAccountConfigValues($email,$password,$transactionsRetentionInterval,$transactionDetailsRetentionInterval);

        } catch (Exception $ex) {
            throw new \Exception("Could not save account information");
        }
    }

    protected function getContracts($email,$password)
    {
        $proxy = Proxy::createFor($email, $password);
        $contracts = null;

        try {
            $contracts = $proxy->getContracts();
        } catch (Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return $contracts;
    }

    protected function clearAll()
    {
        $this->configInfoRepository->deleteAllConfig();
        $this->attributeMappingRepository->deleteAllAttributeMapping();
        $this->contractRepository->deleteAllContracts();
        $this->productFilterRepository->deleteAllProductFilter();

        //TO DO DELETE queue,runnerToken,Schedule
    }
}

?>