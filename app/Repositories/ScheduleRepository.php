<?php 

namespace App\Repositories;

use App\Repositories\ScheduleInterface;
use App\Schedule;


class ScheduleRepository implements ScheduleInterface
{
    public function saveSchedule($contractId,array $data)
    {     
        $schedule = new Schedule;
        
        if($contractId != null && $contractId != 0)
            $schedule = $this->getScheduleByContractId($contractId);

        $startAt = $data['startAt'];
        $isEnabledExport = (bool)$data['enableExport'];
        $exportInterval = (int)$data['exportInterval'];

        $schedule->enableExport = $isEnabledExport;
        $schedule->contractId = $contractId;

        if ($isEnabledExport) {
            $schedule->exportStart = $startAt;
            $schedule->nextStart = $startAt;
            $schedule->exportInterval = $exportInterval;
        } else {
            $schedule->exportStart = null;
            $schedule->nextStart = null;
            $schedule->exportInterval = $exportInterval;
        }

        $schedule->save();
    }

    public function getScheduleByContractId($contractId)
    {
        $scheduleOriginal  = Schedule::where('contractId',$contractId)->first();

        return $scheduleOriginal != null ? $scheduleOriginal : new Schedule;
    }

    public function getAllSchedule()
    {
        $scheduleList = Schedule::all();
        
        return $scheduleList;
    }

    public function saveImportSchedule($contractId,array $data)
    {   
        $schedule = new Schedule;
        
        if($contractId != null && $contractId != 0)
            $schedule = $this->getScheduleByContractId($contractId);

         $isEnabled = $data['enableImport'];
         $schedule->enableImport = $isEnabled;
         $schedule->contractId = $contractId;

        $database->save($schedule);
    }
}