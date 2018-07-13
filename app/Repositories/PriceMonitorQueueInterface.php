<?php

namespace App\Repositories;

use App\PriceMonitorQueue;

interface PriceMonitorQueueInterface
{
    public function savePriceMonitorQueue($queueName,array $data);

    public function getQueueByName($queueName);

    public function getQueueByIdName($id,$queueName);

    public function deleteAllQueue();

    public function deleteQueue($storageModelId,$queueName);

    public function updateReservationTime($queueName, array $storageModel);
}
