<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Services\CoreServices\RunnerService;
use App\RunnerToken;
use App\Repositories\RunnerTokenInterface;
use App\Repositories\RunnerTokenRepository; 

class SyncController extends Controller
{
    /**
    * The runner service instance.
    */
    protected $runnerService;

    /**
    * The runner token instance.
    */
    protected $runnnerTokenRepository;

    public function __construct(RunnerService $runnerService,RunnerTokenRepository $runnnerTokenRepository)
    {
        $this->runnerService = $runnerService;
        $this->runnnerTokenRepository = $runnnerTokenRepository;
    }


    public function run(Request $request)
    {
        $requestData = $request->all();

        if($requestData == null)
           throw new \Exception("Request data are null");

        $queueName = $requestData['queueName'];
        $token = $requestData['token'];

        if ($this->validateRunActionRequestAndRemoveRequestToken($token)) {
            $this->runnerService->runSync($queueName);
        } else {
            
        }
    }

    protected function validateRunActionRequestAndRemoveRequestToken($token)
    {
        if ($token === null) 
            return false;

        try {
            $this->runnnerTokenRepository->deleteToken($token);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}
