<?php

namespace App\Repositories;

use App\Contract;

interface ContractInterface
{
    /**
     * Save contracts list
     *
     * @param array $data
     * @return void
     */
    public function saveContracts(array $data);

    /**
     * Add a new task to the Contracts list
     *
     * @param array $contract
     * @return void
     */

    public function saveContract(Contract $contract);

 
    /**
     *  Contract list
     *
     * @return Contracts[]
     */
    public function getContracts();

 
     /**
     *  Contract list
     *
     * @return Contract
     */
    public function getContractById($id);
    

     /**
     *  Contract list
     *
     * @return Contracts[
     */
    public function getContractByPriceMonitorId($priceMonitorId);

    /**
     *  deleteAllContract
     *
     * @return void
     */

    public function deleteAllContracts();
    
   /**
     *  Update contract info
     *
     * @return Contract
     */

    public function updateContract(array $data);

}
