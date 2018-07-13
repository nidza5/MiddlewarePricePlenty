<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\ProductFilter;
use App\Repositories\ProductFilterInterface;
use App\Repositories\ProductFilterRepository;
use App\Services\FilterService;
use Patagona\Pricemonitor\Core\Sync\Filter\FilterRepository;

class FilterController extends Controller
{

     /**
     * The product filter repository instance.
     */
    protected $productFilterRepository;

    protected $filterService;

    public function __construct(ProductFilterRepository $productFilterRepository,FilterService $filterService)
    {
        $this->productFilterRepository = $productFilterRepository;
        $this->filterService = $filterService;
    }

    public function getFilters(Request $request)
    {
        $requestData = $request->all();
        $priceMonitorId = 0;

        if($requestData == null)
            return;

        $priceMonitorId = $requestData['priceMonitorId'];
        $filterType = $requestData['filterType'];

        if($priceMonitorId == null || $filterType == null)
            throw new \Exception("Price monitor id or filter type is null");

        $filter = $this->filterService->getFilter($filterType,$priceMonitorId);

        return $filter;
    }

    public function saveFilter(Request $request)
    {
        $requestData = $request->all();

        $priceMonitorId = $requestData['priceMonitorId'];

        if($priceMonitorId === null)
            throw new \Exception(config('constants.apiResponse.REQUEST_INVALID_CONTRACT_ID'));
        
        $this->filterService->saveFilter($requestData['filters'],$requestData['type'],$priceMonitorId);

        $filter = $this->filterService->getFilter($requestData['type'],$priceMonitorId);

        return $filter;
    }

    public function preview(Request $request)
    {
        $requestData = $request->all();

        $filterType = $requestData['filterType'];
        $priceMonitorId = $requestData['priceMonitorId'];
        $allVariations = json_decode($requestData['allVariations'],true);
        $attributesFromPlenty = json_decode($requestData['attributesFromPlenty'],true);

        $filter = (new FilterRepository())->getFilter($priceMonitorId, config('constants.filterType.EXPORT_PRODUCTS'));          

        $filteredVariation = $this->filterService->getFilteredVariations($filter, $priceMonitorId, $allVariations,$attributesFromPlenty);

        return $filteredVariation; 
    }
}
