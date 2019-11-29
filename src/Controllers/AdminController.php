<?php declare(strict_types=1);

namespace App\Controllers;

use App\Util\AppSession;
use App\View\FrontRenderInterface;
use Hashids\Hashids;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends BaseController
{
    private $model;

    public function __construct (
        Request $request,
        FrontRenderInterface $view,
        Hashids $hashids,
        AppSession $session
    ) {
        parent::__construct($request, $view, $hashids, $session);
    }

    public function login()
    {
        return $this->render('admin/login');
    }

    public function letMeIn()
    {
        print_r($this->request->request->all());
    }
}