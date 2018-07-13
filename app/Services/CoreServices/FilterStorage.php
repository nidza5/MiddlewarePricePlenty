<?php

namespace App\Services\CoreServices;

use Patagona\Pricemonitor\Core\Interfaces\FilterStorage as FilterStorageInterface;
use App\Repositories\ProductFilterInterface;
use App\Repositories\ProductFilterRepository;

class FilterStorage implements FilterStorageInterface
{

    private $productFilterRepository;

    public function __construct()
    {
        $this->productFilterRepository = new ProductFilterRepository;
    }

   /**
     * Saves serialized filter.
     *
     * @param string $contractId Pricemonitor contract ID.
     * @param string $type Possible values export_products and import_prices.
     * @param string $filter Serialized Filter object.
     *
     * @return void
     * @throws Exception
     */
    public function saveFilter($contractId, $type, $filter)
    {
        try {  
            $this->productFilterRepository->saveProductFilter($contractId,$type, $filter);
        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Gets serialized filter from the DB.
     *
     * @param string $contractId Pricemonitor contract ID.
     * @param string $type Possible values export_products and import_prices.
     *
     * @return string|null
     */
    public function getFilter($contractId, $type)
    {
        $filterModel = $this->productFilterRepository->getFilterByContractIdAndType($contractId, $type);

        return $filterModel->serializedFilter;
    }
}

?>