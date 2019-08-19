<?php declare (strict_types=1);

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;
use App\View\FrontRenderInterface;
use App\Models\HomeModel;
use Hashids\Hashids;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Util\AppSession;
use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\HttpFoundation\RedirectResponse;

// use DB\Model\UserModel;

class Home extends BaseController
{
    private $model;

    public function __construct(
        Request $request,
        FrontRenderInterface $view,
        HomeModel $model,
        Hashids $hashid,
        AppSession $session
    ) {
        parent::__construct($request, $view, $hashid, $session);
        $this->model = $model;
    }

    public function show(array $params = []) : Response
    {
        return $this->view->render('home', [
            'name' => 'not me',
            // 'data' => $this->model->readAll(),
            'hashid' => $this->hashid
        ]);
    }
}
