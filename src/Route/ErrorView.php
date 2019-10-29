<?php declare(strict_types=1);

namespace App\Route;

use App\View\FrontRenderInterface;

class ErrorView
{
    private $engine;

    public function __construct(
        FrontRenderInterface $engine
    ) {
        $this->engine = $engine;
    }

    public function show(int $errCode) : void
    {
        // the page die ex. /error/p404.php
        $this->engine->render('error/p' . $errCode);
    }
}
