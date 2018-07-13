<?php 

namespace App\Repositories;

use App\Contract;
use App\Repositories\ContractInterface;

class ContractRepository implements ContractInterface
{
    public function saveContracts(array $data)
    {

        foreach ($data as $contractPricemonitorId => $contractName) {
            
            $contract = new Contract;
            $contract->priceMonitorId = $contractPricemonitorId;
            $contract->name = $contractName;

            $this->saveContract($contract);
        }
    }

    public function saveContract(Contract $contractObject)
    {
        try {

            if($contractObject == null)
               return;

            $contract = new Contract;

            $contractId = $contractObject->id;

            if($contractId == 0)
            {
                 $contract =  $this->getContractByPriceMonitorId($contractObject->priceMonitorId);

                if($contract != null  && isset($contract->id))
                    $contractId = $contract->id;
            }
               
            $contract = $this->getContractById($contractId);

            $contract->priceMonitorId = $contractObject->priceMonitorId;

            if(isset($contractObject->name))
                $contract->name = $contractObject->name;

            if(!empty($contractObject->salesPricesImport))
                $contract->salesPricesImport = $contractObject->salesPricesImport;
            else if(!empty($contract->salesPricesImport))
                $contract->salesPricesImport = $contract->salesPricesImport; 
             else
                $contract->salesPricesImport = "";
                
             if(isset($contractObject->isInsertSalesPrice))
                $contract->isInsertSalesPrice = $contractObject->isInsertSalesPrice;
            else if(!empty($contract->isInsertSalesPrice))
                $contract->isInsertSalesPrice = $contract->isInsertSalesPrice;
            else
                $contract->isInsertSalesPrice = false;

             $contract->save();
            
        } catch(\Exception $ex) {

            return $ex->getMessage();
        }
    }

    public function getContracts()
    {
        $contracts = Contract::all();
        return $contracts;
    }

    public function getContractById($id)
    {
        if($id == 0 || $id == null)
            return new Contract;

         $contractObject = Contract::find($id);

         return  $contractObject; 
    }

    public function getContractByPriceMonitorId($priceMonitorId)
    {
        $contractOriginal  = Contract::where('priceMonitorId',$priceMonitorId)->first();

        return $contractOriginal != null ? $contractOriginal : new Contract;
    }

    public function deleteAllContracts()
    {
        $contracts = $this->getContracts();

        foreach($contracts as $contract)
            $contract->delete();
    }

    public function updateContract(array $data)
    {
        $contract = new Contract;
        $contract->id = (int)$data['id'];
        $contract->priceMonitorId = $data['priceMonitorId'];
        $contract->salesPricesImport = $data['salesPricesImport'];
        $contract->isInsertSalesPrice = $data['isInsertSalesPrice'] == "true" ? true : false;

        $this->saveContract($contract);
       
       return $contract;
    }

}