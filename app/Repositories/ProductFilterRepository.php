<?php 

namespace App\Repositories;

use App\ConfigInfo;
use App\Repositories\ProductFilterInterface;
use App\ProductFilter;

class ProductFilterRepository implements ProductFilterInterface
{
    public function getFilterByContractIdAndType($contractId,$type)
    {
        if($contractId == 0 || $contractId == null)
            return new ProductFilter;

        $productFilter  = ProductFilter::where('contractId',$contractId)->where('type',$type)->first();

        return $productFilter != null ? $productFilter : new ProductFilter;
    }

    public function getAllFilters() :array
    {
        $filters = ProductFilter::all();
        return $filters;
    }

    public function saveProductFilter($contractId, $filterType, $serializedFilter)
    {
        $productFilter = new ProductFilter;

        if($contractId != null && $filterType != null)
            $productFilter = $this->getFilterByContractIdAndType($contractId,$filterType);

        $productFilter->contractId = $contractId;

        $productFilter->type = $filterType;

        $productFilter->serializedFilter = $serializedFilter;

        $productFilter->save();
    }

    public function deleteAllProductFilter()
    {
        $productFilterList = ProductFilter::all();
 
        foreach($productFilterList as $con)
           $con->delete();           
    }    
}