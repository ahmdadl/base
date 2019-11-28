<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Comment;
use Symfony\Component\HttpFoundation\Request;
use App\View\FrontRenderInterface;
use App\Util\AppSession;
use App\Util\Filter;
use Hashids\Hashids;
use PHPUnit\Util\Json;
use stdClass;
use Symfony\Component\HttpFoundation\JsonResponse;

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
        $name = Filter::filterStr($this->post('name'));
        $email = Filter::filterStr($this->post('email'));
        $message = Filter::filterStr($this->post('message'));

        $errors = new class {
            public $name = false;
            public $email = false;
            public $message = false;
        };

        if (!$name || !Filter::len($name, 5, 255)) {
            $errors->name = true;
        }
    }
}
