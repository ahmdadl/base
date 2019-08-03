<?php declare (strict_types = 1);

namespace App\Middlewares;

interface MiddlewareInterface
{
    public function process() : bool;
}