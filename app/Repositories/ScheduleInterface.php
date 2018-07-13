<?php

namespace App\Repositories;

use App\Schedule;

interface ScheduleInterface
{
    public function saveSchedule($contractId,array $data);

    public function getScheduleByContractId($contractId);

    public function getAllSchedule();

    public function saveImportSchedule($contractId,array $data);

}
