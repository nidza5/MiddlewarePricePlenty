<?php 

namespace App\Repositories;

use App\PriceMonitorQueue;
use App\Repositories\PriceMonitorQueueInterface;

class PricemonitorQueueRepository implements PriceMonitorQueueInterface
{
    public function savePriceMonitorQueue($queueName,array $data)
    {
        $queueModel = new PriceMonitorQueue;
  
        if($data['id'] === null || $data['id'] === 0)
        {
            $queueModel->queueName = $queueName;
        } else {
            $queueModel = $this->getQueueByIdName($data['id'],$queueName);
  
            if($queueModel->id === 0 || $queueModel->id === null)
                return false;
        }
  
          $reservationTime = $data['reservationTime'] != null ?
                  $data['reservationTime']->format('Y-m-d H:i:s') : null;
          
          $queueModel->reservationTime = $reservationTime;
          $queueModel->attempts = $data['attempts'] !== null ? $data['attempts'] : "";
          $queueModel->payload = $data['payload'] !== null ? $data['payload'] : "";
  
          $queueModel->save();
    }

    public function getQueueByName($queueName)
    {        
        $queueOriginal  = PriceMonitorQueue::where('queueName',$queueName)->first();

        return $queueOriginal != null ? $queueOriginal : new PriceMonitorQueue;
    }

    public function getQueueByIdName($id,$queueName)
    {
        $queueOriginal  = PriceMonitorQueue::where('id',$id)->where('queueName',$queueName)->first();
        
        return $queueOriginal != null ? $queueOriginal : new PriceMonitorQueue;
    }

    public function deleteAllQueue()
    {
        $queueList = PriceMonitorQueue::all();
 
        foreach($queueList as $con)
           $con->delete();    
    }

    public function deleteQueue($storageModelId,$queueName)
    { 
        $queue = $this->getQueueByIdName($storageModelId,$queueName);

        if($queue != null)
            $queue->delete();
    }

    public function updateReservationTime($queueName, array $storageModel)
    { 
        $queue = $this->getQueueByIdName($storageModel["id"],$queueName);

        if($queue != null) {
            $queue->reservationTime = null;
            $queue->save();
        }
    }
}