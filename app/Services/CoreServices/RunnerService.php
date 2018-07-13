<?php

namespace App\Services\CoreServices;

use Patagona\Pricemonitor\Core\Infrastructure\ServiceRegister;
use Patagona\Pricemonitor\Core\Sync\PriceImport\Job as PriceImportJob;
use Patagona\Pricemonitor\Core\Sync\ProductExport\Job as ProductExportJob;
use Patagona\Pricemonitor\Core\Sync\Queue\Queue;
use Patagona\Pricemonitor\Core\Sync\Runner\Runner;
use App\Services\StringUtils;
use App\RunnerToken;
use App\Repositories\RunnerTokenInterface;
use App\Repositories\RunnerTokenRepository;
use App\Services\CoreServices\PriceMonitorHttpClient;
use URL;

class RunnerService
{
    const DEFAULT_QUEUE_NAME = 'Default';
    const STATUS_CHECKING_QUEUE_NAME = 'StatusChecking';

    protected $runnerTokenRepository;

    public function __construct()
    {
        $this->runnerTokenRepository = new RunnerTokenRepository;
    }
    
    /**
     * Creates new export product job.
     *
     * @return void
     * @param $pricemonitorContractId
     */
    public function enqueueProductExportJob($pricemonitorContractId)
    {
        $queue = new Queue();
        $queue->enqueue(new ProductExportJob($pricemonitorContractId));
    }

    /**
     * Creates new import price job.
     *
     * @return void
     * @param $pricemonitorContractId
     */
    public function enqueuePriceImportJob($pricemonitorContractId)
    {
        $queue = new Queue();
        $queue->enqueue(new PriceImportJob($pricemonitorContractId));
    }

    /**
     * Runs sync request.
     *
     * @param string $queueName If not provided, default queue name will be used.
     *
     * @return void
     * @throws Exception
     */
    public function runSync($queueName = null)
    {
        $queueName = $queueName === null ? self::DEFAULT_QUEUE_NAME : $queueName;

        $runner = new Runner($queueName);
        $runner->run();

        $this->runAsync($queueName);
        if ($queueName === self::DEFAULT_QUEUE_NAME) {
            $this->runAsync(self::STATUS_CHECKING_QUEUE_NAME);
        }
    }

    /**
     * Runs async request.
     *
     * @param string $queueName If not provided, default queue name will be used.
     *
     * @return void
     * @throws Exception
     */
    public function runAsync($queueName = null)
    {
        $queueName = $queueName === null ? self::DEFAULT_QUEUE_NAME : $queueName;

        // check queue first. If queue is empty run is complete, just skip.
        $queue = ServiceRegister::getQueueStorage()->peek($queueName);

        if (!empty($queue)) {
            $runnerToken = $this->createRunnerToken();
            $this->callAsyncRequest($runnerToken, $queueName);
        }
    }

    protected function createRunnerToken()
    {
        $hashUniqueToken = StringUtils::getUniqueString(20);
        return $this->runnerTokenRepository->saveRunnerToken($hashUniqueToken);
    }

    
    protected function callAsyncRequest($token, $queueName)
    {
        $baseUrl = URL::to('/');

        $url = $baseUrl.'/api/sync?queueName='.$queueName.'&token='.$token;

        ServiceRegister::getHttpClient()->requestAsync('GET', $url);
    }
}