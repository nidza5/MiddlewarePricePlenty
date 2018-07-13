<?php 

namespace App\Repositories;

use App\AttributeMapping;
use App\Repositories\AttributesMappingInterface;

class AttributesMappingRepository implements AttributesMappingInterface
{
    public function saveAttributeMapping($contractId, $contractPricemonitorId,array $mappings)
    {
        $this->deleteMappingsForContract($contractPricemonitorId);

        foreach($mappings as $mapping) {
            
            $attributeMapping = new AttributeMapping;
            $attributeMapping->attributeCode = $mapping['attributeCode'];
            $attributeMapping->priceMonitorCode = $mapping['pricemonitorCode'];
            $attributeMapping->operand = $mapping['operand'];
            $attributeMapping->value = $mapping['value'];
            $attributeMapping->contractId = $contractId;
            $attributeMapping->priceMonitorContractId = $contractPricemonitorId;

            $attributeMapping->save();
       }
    }

    public function getAttributeMappingByPriceMonitorId($priceMonitorId)
    {
        $attributeMappingOriginal = AttributeMapping::where('priceMonitorContractId',$priceMonitorId)->get();

        if($attributeMappingOriginal == null)
          return new AttributeMapping;

        return $attributeMappingOriginal;
    }

    public function deleteMappingsForContract($contractPriceMonitorId)
    {
        $mappingforDelete = $this->getAttributeMappingCollectionByPriceMonitorId($contractPriceMonitorId);
        
        foreach($mappingforDelete as $mapDelete)
           $mapDelete->delete();
    }

    public function getAttributeMappingCollectionByPriceMonitorId($priceMonitorId)
    {
        $attributeMappingOriginal = AttributeMapping::where('priceMonitorContractId',$priceMonitorId)->get();

        return $attributeMappingOriginal;
    }

    public function getAllAttributeMappings()
    {
        $attMappingList = AttributeMapping::all();        
        return $attMappingList;
    }

    public function deleteAllAttributeMapping()
    {
        $attMappingList = getAllAttributeMappings(); 

        foreach($attMappingList as $mapDelete)
            $mapDelete->delete();

    }
}