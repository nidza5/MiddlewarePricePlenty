<?php

namespace App\Repositories;

use App\ProductFilter;

interface ProductFilterInterface
{
    /**
     * Get product filter by contractId
     *
     * @param int $contractId
     * @param string $type
     * @return ProductFilter
     */
    public function getFilterByContractIdAndType($contractId,$type);

    /**
     * Get all filters
     */
    public function getAllFilters() :array;

    /**
     * Save product filter
     *
     * @param array $productFilterData
     * @return void
     */

    public function saveProductFilter($contractId, $filterType, $serializedFilter);

    /**
     *  delete all product filter
     *
     * @return void
     */

    public function deleteAllProductFilter();

}
