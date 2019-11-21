<?php declare(strict_types=1);

namespace App\Controllers;

abstract class BaseController
{
    public function redirect(string $target) : RedirectResponse
    {
        return (new RedirectResponse($target))->send();
    }
}