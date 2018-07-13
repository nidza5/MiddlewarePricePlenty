<?php

namespace App\Services;

use App\Contract;
use App\Repositories\ContractInterface;
use App\Repositories\ContractRepository;
use App\Schedule;
use App\Repositories\ScheduleInterface;
use App\Repositories\ScheduleRepository;


class ScheduleService
{
    
    protected $contractRepository;

    protected $scheduleRepository;

    public function __construct()
    {
        $this->contractRepository = new ContractRepository;
        $this->scheduleRepository = new ScheduleRepository;
    }

    public function getAdequateScheduleByContract($priceMonitorId)
    {
        $contract = $this->contractRepository->getContractByPriceMonitorId($priceMonitorId);

        if($contract == null)
            throw new \Exception("Contract is empty");

        $scheduleSaved = $this->scheduleRepository->getScheduleByContractId($contract->id);
        
        return $scheduleSaved;
    }
      
}

?>