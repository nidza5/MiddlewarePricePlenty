<?php

namespace App\Repositories;

use App\AttributeMapping;

interface AttributesMappingInterface
{  
    public function saveAttributeMapping($contractId, $contractPricemonitorId,array $mappings);

    public function getAttributeMappingByPriceMonitorId($priceMonitorId);

    public function deleteMappingsForContract($contractPriceMonitorId);

    public function getAttributeMappingCollectionByPriceMonitorId($priceMonitorId);

    public function getAllAttributeMappings();

    public function deleteAllAttributeMapping();
}
