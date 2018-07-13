<?php

namespace  App\Services\CoreServices;

use Patagona\Pricemonitor\Core\Interfaces\ConfigService as ConfigServiceInterface;
use App\Repositories\ConfigInfoInterface;
use App\Repositories\ConfigInfoRepository;

class ConfigService implements ConfigServiceInterface
{
    private $configInfoRepository;

    public function __construct()
    {
        $this->configInfoRepository = new ConfigInfoRepository;
    }

    public function getCredentials()
    {
        return array(
            'email' => $this->get(config('constants.credentials.email')),
            'password' => $this->get(config('constants.credentials.password'))
        );
    }

    /**
     * Sets clients credentials.
     *
     * @param $email
     * @param $password
     */
    public function setCredentials($email, $password)
    {
        $this->set('email', $email);
        $this->set('password', $password);
    }

     public function getComponentName() {
        return "";
     }

     public function getSource() {
         return "";
     }

        /**
     * Saves config values
     *
     * @param $account
     */
    public function setAccountConfigValues($email,$password,$transactionsRetentionInterval,$transactionDetailsRetentionInterval)
    {
        $this->set(
            config('constants.credentials.email'),
            $email
        );
        $this->set(
            config('constants.credentials.password'),
            $password
        );
        $this->set(
            config('constants.credentials.transactionsRetentionInterval'),
            $transactionsRetentionInterval
        );
        $this->set(
            config('constants.credentials.transactionDetailsRetentionInterval'),
            $transactionDetailsRetentionInterval
        );
    }

     public function get($key) {

        $configValueObject = $this->configInfoRepository->getConfig($key);

        $configValue = $configValueObject != null ? $configValueObject->value : '';

        return !empty($configValue) ? $configValue : '';
     }

     public function set($key, $value) 
     {
        try {
        
          $this->configInfoRepository->saveConfig($key,$value);
        
        } catch (Exception $e) {

           // Logger::logError($e->getMessage());
        }    
     }
}

?>