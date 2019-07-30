<?php declare (strict_types=1);

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;
use App\View\FrontRenderInterface;
use DB\Model\HomeModel;
// use DB\Model\UserModel;

class Home
{
    private $request;
    private $view;
    private $model;

    public function __construct(
        Request $request,
        FrontRenderInterface $view,
        HomeModel $model
    ) {
        $this->request = $request;
        $this->view = $view;
        $this->model = $model;
    }

    public function show($params = [])
    {
        // $con = new \App\DbConfig\MySqli();
        // var_dump($con);
        $this->view->render('home', [
            'name' => 'not me',
            'data' => $this->model->readAll()
        ]);
    }
}
