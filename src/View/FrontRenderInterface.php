<?php declare (strict_types=1);

namespace App\View;

use Symfony\Component\HttpFoundation\Response;

interface FrontRenderInterface
{
    public function render(string $template, array $params = []) : Response;
}