<?php declare(strict_types = 1);

namespace App\Middlewares;

use Symfony\Component\HttpFoundation\Request;

abstract class Base
{
    protected static $request;
    public function __construct(Request $request)
    {
        self::$request = $request;
    }
}