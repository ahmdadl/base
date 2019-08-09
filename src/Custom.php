<?php declare(strict_types=1);

namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use DB\Model\UserModel;

class Custom
{
    private $request;
    private $response;
    private $model;

    public function __construct(
        Request $request,
        Response $response,
        UserModel $model
    )
    {
        $this->request = $request;
        $this->response = $response;
        $this->model = $model;
    }

    public function getAll()
    {
        $result = $this->model->readAll();

        return new Response(json_encode($result));
    }

    public function getOne()
    {
        $this->model->id = 1;
        $result = $this->model->readOne();

        return new Response(json_encode($result));
    }
}