<?php

declare(strict_types=1);

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;
use App\View\FrontRenderInterface;
use App\Util\AppSession;
use App\Util\Filter;
use App\Models\Home;
use App\Models\Post;
use Hashids\Hashids;

class HomeController extends BaseController
{
    use HomeModelDataTrait;

    protected $model;
    protected $postModel;

    public function __construct(
        Request $request,
        FrontRenderInterface $view,
        Hashids $hashids,
        Home $model,
        Post $postModel,
        AppSession $session
    ) {
        parent::__construct($request, $view, $hashids, $session);
        $this->model = $model;
        $this->postModel = $postModel;
    }

    public function show($params = [])
    {
        [$pros, $projects,] = $this->getData();

        $posts = $this->model->getPosts();

        return $this->view->render('home', [
            'pros' => $pros,
            'projects' => $projects,
            'posts' => $posts,
            'model' => $this->postModel
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

    public function toPosts()
    {
        return $this->redirect('/blog/posts');
    }

    public function handelErrors(array $param)
    {
        $page = isset($param['num']) ? $param['num'] : 404;

        return $this->view->render('error/p' . $page);
    }

    public function changeLang(array $param)
    {
        $code = isset($param['code']) ? $param['code'] : 'en';
        $redirectTo = $this->request->query->get('was', '/');

        $this->session->se->set('lang', $code);
        
        return $this->redirect($redirectTo);
    }
}
