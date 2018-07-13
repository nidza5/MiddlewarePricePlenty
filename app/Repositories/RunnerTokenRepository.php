<?php 

namespace App\Repositories;

use App\RunnerToken;
use App\Repositories\RunnerTokenInterface;

class RunnerTokenRepository implements RunnerTokenInterface
{
    public function saveRunnerToken($token)
    {
        if($token === null)
             return "";
        
        $tokenModel = new RunnerToken;

        $tokenModel->token = $token ;

        $tokenModel->save();

        return $token;
    }

    public function getByToken($token)
    {
        $runnerTokenOriginal  = RunnerToken::where('token',$token)->first();

        return $runnerTokenOriginal != null ? $runnerTokenOriginal : new RunnerToken;
    }

    public function deleteAllTokens()
    {
        $tokensList = RunnerToken::all();
 
        foreach($tokensList as $con)
           $con->delete();
    }

    public function deleteToken($token)
    {
        $runnerTokenOriginal = RunnerToken::where('token',$token)->first();

        if($runnerTokenOriginal != null)
           $runnerTokenOriginal->delete();
    }
}