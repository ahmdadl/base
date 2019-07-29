<?php declare (strict_types=1);

namespace App\Controllers;

use Symfony\Component\HttpFoundation\{
    Request,
    Response
};

class Home
{
    private $request;
    private $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function show($params = [])
    {
        $this->response->setContent('<h1>Ahmed Adel</h1>');
    }
}
