<?php

namespace App\Repositories;

use App\ConfigInfo;

interface ConfigInfoInterface
{
    public function saveConfig($key, $value);

    public function getConfig($key);

    public function getConfigInfoValue($key);

    public function deleteAllConfig();

}
