<?php declare(strict_types = 1);

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;
use App\View\FrontRenderInterface;
use Hashids\Hashids;
use App\Util\AppSession;
use App\Models\AuthorModel;
use Symfony\Component\HttpFoundation\Response;

class Auth extends BaseController{
    private $model;

    public function __construct(
        Request $request,
        FrontRenderInterface $view,
        Hashids $hashid,
        AppSession $session,
        AuthorModel $model
    ) {
        parent::__construct($request, $view, $hashid, $session);
        $this->model = $model;
    }

    public function logIn(array $param = [])
    {
        
    }

    public function show(array $param = []) : Response
    {
        return $this->view->render($param['temp'], $param['data']);
    }
}