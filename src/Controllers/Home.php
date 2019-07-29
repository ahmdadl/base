<?php declare (strict_types=1);

namespace App\Controllers;

use Symfony\Component\HttpFoundation\{
    Request,
    Response
};
// use League\Plates\Engine;
// use League\Plates\Extension\Asset;

use App\View\FrontRenderInterface;
class Home
{
    private $request;
    private $response;
    private $view;

    public function __construct(
        Request $request,
        Response $response,
        FrontRenderInterface $view
    ) {
        $this->request = $request;
        $this->response = $response;
        $this->view = $view;
        
    }

    public function show($params = [])
    {
        $this->view->render('home', ['name' => 'not me']);
    }
}
