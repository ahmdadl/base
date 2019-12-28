<?php declare (strict_types=1);

namespace App\View;

interface FrontRenderInterface
{
    public function render(string $template, array $params = []);
}