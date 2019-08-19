<?php declare(strict_types = 1);

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;
use App\View\FrontRenderInterface;
use Hashids\Hashids;
use App\Util\AppSession;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController
{
    protected $request;
    protected $view;
    protected $hashid;
    protected $session;

    public function __construct(
        Request $request,
        FrontRenderInterface $view,
        Hashids $hashid,
        AppSession $session
    ) {
        $this->request = $request;
        $this->view = $view;
        $this->hashid = $hashid;
        $this->session = $session;
        $this->session->sessStart();
    }

    abstract public function show(array $params = []) : Response;
}