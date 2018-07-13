<?php

namespace App\Services\CoreServices;

use Patagona\Pricemonitor\Core\Interfaces\MapperService as MapperServiceInterface;
use App\AttributeMapping;
use App\Repositories\AttributesMappingInterface;
use App\Repositories\AttributesMappingRepository;
use App\Services\PlentyMarketServiceApi;

class MapperService implements MapperServiceInterface
{ 

    /**
     * The attributes mapping repository instance.
     */
    protected $attributesMappingRepository;

    protected $plentyServiceApi;

    public function __construct()
    {
        $this->attributesMappingRepository = new AttributesMappingRepository;
        $this->plentyServiceApi = new PlentyMarketServiceApi;
    }

    /**
     * Mandatory attributes
     *
     * @var array
     */
    public static $mandatoryAttributes = array(
        'gtin',
        'name',
        'referencePrice',
        'minPriceBoundary',
        'maxPriceBoundary'
    );

    public static $operands = array(
        null,
        'add',
        'sub',
        'mul',
        'div',
    );

    /**
     * Gets mapping attributes
     *
     * @param $pricemonitorContractId
     *
     * @return array
     */
    public function getMappedAttributes($pricemonitorContractId)
    {
        $mappings = $this->getAttributesMapping($pricemonitorContractId)->toArray();
        return $this->reformatMappings($mappings['items']);
    }

    /**
     * Checks if all mandatory attributes are mapped.
     *
     * @param string $pricemonitorContractId
     *
     * @return bool
     */
    public function hasMandatoryMappings($pricemonitorContractId)
    {
        $mappings = $this->getMappedAttributes($pricemonitorContractId);
        $diff = array_diff(self::$mandatoryAttributes, array_column($mappings, 'pricemonitorCode'));
        return empty($diff);
    }

    public function getMappedAttributeCodes($pricemonitorContractId)
    {
        $mappings = $this->getAttributesMapping($pricemonitorContractId)->toArray();
        $mappingCodes = array_unique(array_column($mappings, 'attributeCode'));
        $mappingCodes[] = 'tax_class_id';
        return $mappingCodes;
    }

    public function getCalculatedPrice($shopValue, $calculationValue, $operand)
    {
        $result = (double)$shopValue;
        $value = (double)$calculationValue;

        if (!in_array($operand, self::$operands)) {
            throw new \Exception('Operand %s is not supported.', $operand);
        }

        switch ($operand) {
            case 'add':
                $result = $shopValue + $value;
                break;
            case 'sub':
                $result = $shopValue - $value;
                break;
            case 'mul':
                $result = $shopValue * $value;
                break;
            case 'div':
                $result = $shopValue / $value;
                break;
        }

        return $result;
    }

    /**
     * Converts integration specific products to Pricemonitor product format
     *
     * @param string $contractId Pricemonitor contract id
     * @param array $shopProduct Shop products that needs to be converted to Pricemonitor product format
     *
     * @return array Converted Pricemonitor product
     */
    public function convertToPricemonitor($contractId, $shopProduct)
    {
        $result = array('productId' => $shopProduct['id']);
        $mappings = $this->getAttributesMapping($contractId);
        //$contract = $this->getContractById($contractId);

        if (empty($mappings)) {
            return array();
        }

        $productAttributes =  $this->plentyServiceApi->getAttributesFromPlenty();

        if( $productAttributes !== null)
             $productAttributes = json_decode($productAttributes,true);

        foreach ($mappings as $mapping) {

            $attributeCode = $mapping->attributeCode;
            $pricemonitorCode = $mapping->priceMonitorCode;

            if($pricemonitorCode === 'minPriceBoundary' || $pricemonitorCode === 'maxPriceBoundary' || $pricemonitorCode === 'referencePrice')
                $value = $shopProduct[$attributeCode];
            else {
                $columnNameInShopProduct = $productAttributes['data'][$attributeCode];
                $value = $shopProduct[$columnNameInShopProduct];
            }

            if (in_array($pricemonitorCode, self::$mandatoryAttributes)) {
                if ($pricemonitorCode === 'minPriceBoundary' || $pricemonitorCode === 'maxPriceBoundary') {
                    $value = $this->getCalculatedPrice(
                        $value,
                        $mapping['value'],
                        $mapping['operand']
                    );
                }

                $result[$pricemonitorCode] = $value;

            } else {
                $result['tags'][] = array(
                    'key' => $pricemonitorCode,
                    'value' => (string)$value
                );
            }           
        }

        echo "result";
        echo json_encode($result);
        return $result;
    }

    /**
     * @param array $mappings
     *
     * @return array
     */
    protected function reformatMappings($mappings)
    {
        $result = array();

        foreach ($mappings as $mapping) {
            $result[] = array(
                'id' => $mapping['id'],
                'value' => $mapping['value'],
                'operand' => $mapping['operand'],
                'attributeCode' => $mapping['attributeCode'],
                'pricemonitorCode' => $mapping['priceMonitorCode'],
            );
        }

        return $result;
    }


    protected function getAttributesMapping($contractId)
    {
        $attributeMappingModel = $this->attributesMappingRepository->getAttributeMappingByPriceMonitorId($contractId);
        return $attributeMappingModel;
    }
}

?>