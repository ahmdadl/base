<?php declare (strict_types=1);

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;
use App\View\FrontRenderInterface;
use DB\Model\HomeModel;
use Hashids\Hashids;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Util\AppSession;

// use DB\Model\UserModel;

class Home
{
    private $request;
    private $view;
    private $model;
    private $hashid;
    private $session;

    public function __construct(
        Request $request,
        FrontRenderInterface $view,
        HomeModel $model,
        Hashids $hashid,
        AppSession $session
    ) {
        $this->request = $request;
        $this->view = $view;
        $this->model = $model;
        $this->hashid = $hashid;
        $this->session = $session;
        if ($this->request->hasPreviousSession()){
            $this->session->sessStart();
        }
    }

    public function show($params = []) : void
    {
        // var_dump($this->request->hasPreviousSession());
        // var_dump($this->session);
        // var_dump(ini_get('session.use_strict_mode'));
        $this->view->render('home', [
            'name' => 'not me',
            'data' => $this->model->readAll(),
            'hashid' => $this->hashid
        ]);
    }
}
