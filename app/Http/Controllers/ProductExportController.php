<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Schedule;
use App\Repositories\ScheduleInterface;
use App\Repositories\ScheduleRepository;
use App\Services\ScheduleService;
use App\Contract;
use App\Repositories\ContractInterface;
use App\Repositories\ContractRepository;
use App\Services\CoreServices\RunnerService;

class ProductExportController extends Controller
{
     /**
     * The schedule repository instance.
     */
    protected $scheduleRepository;

    /**
     * The schedule service instance.
    */
    protected $scheduleService;

    /**
     * The contract repository instance.
    */
    protected $contractRepository;

    /**
     * The runner service instance.
    */
    protected $runnerService;

    public function __construct(ScheduleRepository $scheduleRepository,ScheduleService $scheduleService,ContractRepository $contractRepository,RunnerService $runnerService)
    {
        $this->scheduleRepository = $scheduleRepository;
        $this->scheduleService = $scheduleService;
        $this->contractRepository = $contractRepository;
        $this->runnerService = $runnerService;
    }

    public function getSchedule(Request $request)
    {
        $requestData = $request->all();
        $priceMonitorId = 0;

        if($requestData != null)
            $priceMonitorId = $requestData['pricemonitorId'];

        if($priceMonitorId === 0 || $priceMonitorId === null)
            throw new \Exception("PriceMonitorId is empty");

         $scheduleSaved =  $this->scheduleService->getAdequateScheduleByContract($priceMonitorId);

         return $scheduleSaved;
    }

    public function saveSchedule(Request $request)
    {
        $requestData = $request->all();

        if($requestData == null)
            throw new \Exception("Request data are empty!");

        $priceMonitorId = $requestData['pricemonitorId'];
       
        if($priceMonitorId === 0 || $priceMonitorId === null)
            throw new \Exception("PriceMonitorId is empty");
        
        $contract = $this->contractRepository->getContractByPriceMonitorId($priceMonitorId);

        if($contract == null)
            throw new \Exception("Contract is empty");

         $this->scheduleRepository->saveSchedule($contract->id,$requestData);

         $scheduleSaved = $this->scheduleRepository->getScheduleByContractId($contract->id);

         return $scheduleSaved;        
    }

    public function runProductExport(Request $request)
    {

        echo phpinfo();
        $requestData = $request->all();

        if($requestData == null)
            throw new \Exception("Request data are empty!");

        $priceMonitorId = $requestData['pricemonitorId'];

        if($priceMonitorId === 0 || $priceMonitorId === null)
            throw new \Exception("PriceMonitorId is empty");

        $contract = $this->contractRepository->getContractByPriceMonitorId($priceMonitorId);

        if (!$contract->id) {
            throw new \Exception("Invalid Pricemonitor contract ID!");
        }

        $this->runnerService->enqueueProductExportJob($priceMonitorId);

        try {
            $this->runnerService->runAsync();
        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return config('constants.apiResponse.PRODUCT_EXPORT_STARTED');
    }
}
