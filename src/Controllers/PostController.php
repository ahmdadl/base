<?php declare(strict_types=1);

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;
use App\View\FrontRenderInterface;
use App\Util\AppSession;

class PostController
{
    
    private $request;
    private $view;
    private $session;
    private $model;

    public function __construct(
        Request $request,
        FrontRenderInterface $view,
        // HomeModel $model,
        AppSession $session
    ) {
        $this->request = $request;
        $this->view = $view;
        // $this->model = $model;
        $this->session = $session;
        $this->session->sessStart();
    }

    public function create()
    {
        return $this->view->render('post/create');
    }
}