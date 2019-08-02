<?php

namespace App\Middlewares;

class Auth
{
    public function process()
    {
        return ['errCode' => false];
    }
}