<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Comment;
use Symfony\Component\HttpFoundation\Request;
use App\View\FrontRenderInterface;
use App\Util\AppSession;
use App\Util\Filter;
use Hashids\Hashids;

class CommentController extends BaseController
{

    public function __construct(
        Request $request,
        FrontRenderInterface $view,
        Comment $model,
        Hashids $hashids,
        AppSession $session
    ) {
        parent::__construct($request, $view, $hashids, $session);
        $this->model = $model;
    }

    public function store()
    {
        echo json_encode($this->request->request->all());
    }
}
