<?php declare(strict_types = 1);

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;
use App\View\FrontRenderInterface;
use App\Models\AuthorModel;

class Author
{
    private $request;
    private $view;
    private $model;
    private $hashid;
    private $session;

    public function __construct(
        Request $request,
        FrontRenderInterface $view,
        AuthorModel $model
    ) {}
}