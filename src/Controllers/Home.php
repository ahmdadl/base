<?php declare (strict_types=1);

namespace App\Controllers;

use Symfony\Component\HttpFoundation\{
    Request,
    Response
};
use League\Plates\Engine;
class Home
{
    private $request;
    private $response;
    private $view;

    public function __construct(
        Request $request,
        Response $response,
        Engine $view
    ) {
        $this->request = $request;
        $this->response = $response;
        $this->view = $view;
    }

    public function show($params = [])
    {
        $html = $this->view->render('home', ['name' => 'ahmed']);
        $this->response->setContent($html);
    }
}
