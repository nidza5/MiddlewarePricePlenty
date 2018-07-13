<?php

namespace App\Services\CoreServices;

use Patagona\Pricemonitor\Core\Interfaces\ProductService as ProductServiceInterface;
use Patagona\Pricemonitor\Core\Sync\Filter\Filter;
use App\Services\FilterService;
use App\Services\PlentyMarketServiceApi;

class ProductService implements ProductServiceInterface
{ 
    protected $filterService;

    protected $plentyServiceApi;

    public function __construct()
    {
        $this->filterService = new FilterService;
        $this->plentyServiceApi = new PlentyMarketServiceApi;
    }

    public function exportProducts($contractId, Filter $filter, array $shopCodes = array())
    {
        if (!$this->isValidFilter($filter)) {
            throw new \Exception('At least one filter group must be applied!');
        }

        $allVariations = null;
        $allAttributes = null;

        $variationFromPlenty =  $this->plentyServiceApi->getVariationsFromPlenty();

        if($variationFromPlenty !== null)
            $allVariations = json_decode($variationFromPlenty,true);

        $attributesFromPlenty =  $this->plentyServiceApi->getAttributesFromPlenty();

        if($attributesFromPlenty !== null)
            $allAttributes = json_decode($attributesFromPlenty,true);
        
        //     echo "all variations";
        // echo json_encode( $allVariations['data']);

        $filteredVariation = $this->filterService->getFilteredVariations($filter, $contractId, $allVariations['data'],$allAttributes['data']);

        // echo "filtered variations";
        // echo json_encode($filteredVariation);

        return $filteredVariation;
    }

    /**
     * Gets product identifier field name, that will be used for querying integration storage.
     *
     * @return string
     */
    public function getProductIdentifier()
    {
        return 'id';
    }

    protected function isValidContract($contract)
    {
        return !empty($contract) && $contract->id !== null;
    }

    /**
     * Checks if filter is valid
     *
     * @param Filter $filter
     *
     * @return bool
     */
    protected function isValidFilter($filter)
    {
        if (empty($filter)) {
            return false;
        }

        $hasExpression = false;
        foreach ($filter->getExpressions() as $group) {
            $expressions = $group->getExpressions();
            if (!empty($expressions)) {
                $hasExpression = true;
            }
        }

        return $hasExpression;
    }
}

?>