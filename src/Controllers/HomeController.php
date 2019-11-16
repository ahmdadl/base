<?php

declare(strict_types=1);

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;
use App\View\FrontRenderInterface;
use App\Util\AppSession;
use App\Util\Filter;
use App\Models\HomeModel;

class HomeController
{
    use HomeModelDataTrait;

    private $request;
    private $view;
    private $session;
    private $model;

    public function __construct(
        Request $request,
        FrontRenderInterface $view,
        HomeModel $model,
        AppSession $session
    ) {
        $this->request = $request;
        $this->view = $view;
        $this->model = $model;
        $this->session = $session;
        $this->session->sessStart();
    }

    public function show($params = [])
    {
        [$pros, $projects, ] = $this->getData();

        $posts = $this->model->getPosts();

        return $this->view->render('home', [
            'pros' => $pros,
            'projects' => $projects,
            'posts' => $posts
        ]);
    }

    public function saveMail($param = [])
    {
        $name = Filter::filterStr($this->request->get('name'));
        $email = filter_var(Filter::filterStr($this->request->get('email')), FILTER_SANITIZE_EMAIL);
        $message = Filter::filterStr($this->request->get('message'));

        $output = (object) [
            'code' => 200,
        ];

        if (!$name) {
            $output->code = 601;
        } else if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $output->code = 602;
        } else if (!$message) {
            $output->code = 603;
        }

        if ($name && $email && $message && $output->code === 200) {
            // all data is valid
            // save email
            $data = (object) [
                'name' => $name,
                'email' => $email,
                'message' => $message
            ];

            if ($this->model->create($data)) {
                $output->code = 200;
            } else {
                $output->code = 400;
            }
        }

        header("Content-Type: application/json");
        echo json_encode($output);
    }
}
