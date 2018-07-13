<?php

namespace App\Repositories;

use App\RunnerToken;

interface RunnerTokenInterface
{
    public function saveRunnerToken($token);

    public function getByToken($token);

    public function deleteAllTokens();

    public function deleteToken($token);

}
