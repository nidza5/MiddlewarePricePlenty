<?php

namespace App\Services\CoreServices;

use Patagona\Pricemonitor\Core\Interfaces\Queue\Storage;
use Patagona\Pricemonitor\Core\Sync\Queue\StorageModel;
use App\PriceMonitorQueue;
use App\Repositories\PriceMonitorQueueInterface;
use App\Repositories\PriceMonitorQueueRepository;
use DateTime;

class QueueStorage implements Storage
{
    protected $priceMonitorQueueRepository;

    public function __construct()
    {
        $this->priceMonitorQueueRepository = new PriceMonitorQueueRepository();
    }
 
    public function peek($queueName)
    {
        return $this->getStorageModel($queueName, false);
    }

    public function lock($queueName)
    {
        return $this->getStorageModel($queueName, true);
    }

    public function save($queueName, $storageModel)
    {
        try {
            $result = $this->setStorageModel($queueName, $storageModel);
        } catch (Exception $e) {
            $result = false;
        }

        return $result;
    }

    public function delete($queueName, $storageModel)
    {
        try {
            $result = $this->unsetStorageModel($queueName, $storageModel);
        } catch (Exception $e) {
            $result = false;
        }

        return $result;
    }

    public function beginTransaction()
    {
     
    }

    public function commit()
    {
       
    }

    public function rollBack()
    {
        
    }

    /**
     * @param string $queueName
     * @param bool $lock
     *
     * @return StorageModel
     */
    protected function getStorageModel($queueName, $lock = false)
    {
        $queueItem = $this->priceMonitorQueueRepository->getQueueByName($queueName);

        if (!$queueItem || !$queueItem->id) 
            return null;        

        $reservationTime = $queueItem->reservationTime === null ? null :
            DateTime::createFromFormat('Y-m-d H:i:s', $queueItem->reservationTime);

        return new StorageModel(
            array(
                'id' => $queueItem->id,
                'reservationTime' => $reservationTime,
                'attempts' => $queueItem->attempts,
                'payload' => $queueItem->payload
            )
        );
    }

 
    protected function setStorageModel($queueName, $storageModel)
    {
        $queueModel = new PriceMonitorQueue;

        if ($storageModel->getId() === null) {
            $queueModel->queueName = $queueName;
        } else {
            $queueModel =  $this->priceMonitorQueueRepository->getQueueByIdName($storageModel->getId(), $queueName);

            if (!$queueModel->id) 
                return false;
        }
    
        $reservationTime = $storageModel->getReservationTime() !== null ?
            $storageModel->getReservationTime()->format('Y-m-d H:i:s') : null;

           
        $queueModel->reservationTime = $reservationTime;
        $queueModel->attempts = $storageModel->getAttempts();
        $queueModel->payload = $storageModel->getPayload();

        $queueModel->save();    
 
        return true;
    }

    
    protected function unsetStorageModel($queueName, $storageModel)
    {
        $this->priceMonitorQueueRepository->deleteQueue($storageModel->getId(),$queueName);
        return true;
    }
}