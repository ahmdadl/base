<?php declare (strict_types=1);

namespace App\Controllers;

use Symfony\Component\HttpFoundation\{
    Request
};
use App\View\FrontRenderInterface;
class Home
{
    private $request;
    private $view;

    public function __construct(
        Request $request,
        FrontRenderInterface $view
    ) {
        $this->request = $request;
        $this->view = $view;
    }

    public function show($params = [])
    {
        $this->view->render('home', ['name' => 'not me']);
    }
}
