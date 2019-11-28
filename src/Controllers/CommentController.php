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
        $postId = $this->post('postId');
        $name = Filter::filterStr($this->post('name'));
        $email = Filter::filterStr($this->post('email'));
        $message = Filter::filterStr($this->post('message'));

        $errors = new class {
            public $pid = false;
            public $name = false;
            public $email = false;
            public $message = false;
            public $done = false;
        };

        if (null === $postId) {
            $errors->pid = true;
        }

        if (!$name || !Filter::len($name, 5, 255)) {
            $errors->name = true;
        }

        if (!$email || !Filter::len($email, 5)) {
            $errors->email = true;
        }

        if (!$message || !Filter::len($message, 5)) {
            $errors->message = true;
        }
    
        if ($name && $email && $message && !$errors->pid) {
            // save comment
            $this->model->postId = (int) $postId;
            $this->model->name = $name;
            $this->model->email = $email;
            $this->model->body = $message;

            if ($this->model->save()) {
                $errors->done = true;
            }
        }

        header('Content-Type: application/json');
        echo json_encode($errors);
    }
}
