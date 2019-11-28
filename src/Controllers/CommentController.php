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

    public function index()
    {
        $postId = Filter::filterStr($this->post('postId'));
        if (null !== $postId) {
            $this->model->postId = (int) $postId;
            $comments = [];
            $data = $this->model->readAll();

            if (sizeof($data)) {
                foreach ($data as $c) {
                    $c->created_at = date_format(date_create($c->created_at), 'd M Y H:ia');

                    $c->email = $this->get_gravatar($c->email);

                    $comments[] = $c;
                }
            }

            header('Content-Type: application/json');
            echo json_encode($comments);
        }
    }

    public function store()
    {
        $postId = $this->post('postId');
        $name = Filter::filterStr($this->post('name'));
        $email = Filter::filterStr($this->post('email'));
        $message = Filter::filterStr($this->post('message'));

        $errors = (object) [
            'pid' => false,
            'name' => false,
            'email' => false,
            'message' => false,
            'done' => false,
        ];

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
                $errors->email = $this->get_gravatar($email);
                $errors->done = true;
            }
        }

        header('Content-Type: application/json');
        echo json_encode($errors);
    }

    /**
     * Get either a Gravatar URL or complete image tag for a specified email address.
     *
     * @param string $email The email address
     * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
     * @param string $d Default imageset to use [ 404 | mp | identicon | monsterid | wavatar ]
     * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
     * @param boole $img True to return a complete IMG tag False for just the URL
     * @param array $atts Optional, additional key/value attributes to include in the IMG tag
     * @return String containing either just a URL or a complete image tag
     * @source https://gravatar.com/site/implement/images/php/
     */
    private function get_gravatar($email, $s = 80, $d = 'mp', $r = 'g', $img = false, $atts = array())
    {
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$s&d=$d&r=$r";
        if ($img) {
            $url = '<img src="' . $url . '"';
            foreach ($atts as $key => $val)
                $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }
        return $url;
    }
}
