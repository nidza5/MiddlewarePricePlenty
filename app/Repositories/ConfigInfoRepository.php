<?php 

namespace App\Repositories;

use App\ConfigInfo;
use App\Repositories\ConfigInfoInterface;

class ConfigInfoRepository implements ConfigInfoInterface
{
    public function saveConfig($key, $value) 
    {
        if($key == null || $value == null)
            return;
    
        $configValues = new ConfigInfo;

        if($key!= null)
            $configValues = $this->getConfig($key);

        $configValues->key = $key;

        $configValues->value = $value;

        $configValues->save();
    }

    public function getConfig($key)
    {
        if($key == null)
            return new ConfigInfo;

        $config = ConfigInfo::where('key',$key)->first();

        return $config != null ? $config : new ConfigInfo;
    }
    
    public function getConfigInfoValue($key) {
        
        $configValueObject = $this->getConfig($key);

        $configValue = $configValueObject != null ? $configValueObject->value : '';

        return !empty($configValue) ? $configValue : '';
    }

    public function deleteAllConfig()
    {
        $configInfoList = ConfigInfo::all();
 
        foreach($configInfoList as $con)
           $con->delete();
    }
}