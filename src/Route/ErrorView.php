<?php declare(strict_types=1);

namespace App\Route;

use Main\Template\FrontendRenderer;
use Symfony\Component\HttpFoundation\Response;

class ErrorView
{
    private $response;
    private $engine;

    public function __construct(
        Response $response,
        FrontendRenderer $engine
    ) {
        $this->response = $response;
        $this->engine = $engine;
    }

    public function show(int $errCode) : void
    {
        $html = $this->engine->render($errCode);
        $this->response->setContent($html);
    }
}