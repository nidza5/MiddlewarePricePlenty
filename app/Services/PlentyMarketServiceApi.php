<?php

namespace App\Services;

use App\Services\CoreServices\PriceMonitorHttpClient;
use App\Services\CoreServices\HttpResponsePlenty;

class PlentyMarketServiceApi
{
    public function getVariationsFromPlenty()
    {
        $client = new PriceMonitorHttpClient();
        $res =  $client->request(
            'GET',
            'https://bb651d7c4e24ff68347d6ef5fef5623b6d3d8261.plentymarkets-cloud-de.com/rest/priceMonitor/variations'
        );

        return $res->getBody();
    }

    public function getAttributesFromPlenty()
    {
        $client = new PriceMonitorHttpClient();
        $res =  $client->request(
            'GET',
            'https://bb651d7c4e24ff68347d6ef5fef5623b6d3d8261.plentymarkets-cloud-de.com/rest/priceMonitor/attributes'
        );

        return $res->getBody();
    }      
}

?>