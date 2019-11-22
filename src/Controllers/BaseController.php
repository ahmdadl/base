<?php declare(strict_types=1);

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;
use App\View\FrontRenderInterface;
use Hashids\Hashids;
use App\Util\AppSession;
use Symfony\Component\HttpFoundation\RedirectResponse;

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

    public function redirect(string $target) : RedirectResponse
    {
        return (new RedirectResponse($target))->send();
    }

    public function render(string $temp, array $param = [])
    {
        return $this->view->render($temp, $param);
    }
}