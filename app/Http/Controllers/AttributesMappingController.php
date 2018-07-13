<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\AttributeMapping;
use App\Repositories\AttributesMappingInterface;
use App\Repositories\AttributesMappingRepository;
use App\Contract;
use App\Repositories\ContractInterface;
use App\Repositories\ContractRepository;

class AttributesMappingController extends Controller
{
    /**
     * The attributes mapping repository instance.
     */
    protected $attributesMappingRepository;

    /**
     * The contract repository instance.
     */
    protected $contractRepository;

    public function __construct(AttributesMappingRepository $attributesMappingRepository,ContractRepository $contractRepository)
    {
        $this->attributesMappingRepository = $attributesMappingRepository;
        $this->contractRepository = $contractRepository;
    }

    public function saveAttributesMapping(Request $request)
    {
        $requestData = $request->all();

        if($requestData == null)
           throw new \Exception("Request data are null");

        $priceMonitorId = $requestData['priceMonitorId'];
        $mappings = json_decode($requestData['mappings'],true);

        if($priceMonitorId === 0 || $priceMonitorId === null)
            throw new \Exception("PriceMonitorId is empty");

        if($mappings == null)
            throw new \Exception("Mappings is empty");

        $contract = $this->contractRepository->getContractByPriceMonitorId($priceMonitorId);

        if($contract == null)
           throw new \Exception("Contract is empty");

        $this->attributesMappingRepository->saveAttributeMapping($contract->id,$contract->priceMonitorId,$mappings);

        return "OK"; 
    }

    public function getMappedAttributes(Request $request)
    {
        $requestData = $request->all();
        $priceMonitorId = 0;

        if($requestData != null)
            $priceMonitorId = $requestData['priceMonitorContractId'];

        $attributeMapping = $this->attributesMappingRepository->getAttributeMappingCollectionByPriceMonitorId($priceMonitorId); 

        return $attributeMapping;
    }
}
