<?php declare (strict_types=1);

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;
use App\View\FrontRenderInterface;
use App\Models\HomeModel;
use Hashids\Hashids;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Util\AppSession;
use Symfony\Component\HttpFoundation\Response;

// use DB\Model\UserModel;

class HomeController
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
        $this->session->sessStart();
    }

    public function show($params = [])
    {
        $pros = [
            (object)[
                'title' => 'Responsive',
                'icon' => 'desktop',
                'txt' => 'some thing to be said about that'
            ],
            (object)[
                'title' => 'Responsive',
                'icon' => 'desktop',
                'txt' => 'some thing to be said about that'
            ],
            (object)[
                'title' => 'Responsive',
                'icon' => 'desktop',
                'txt' => 'some thing to be said about that'
            ],
            (object)[
                'title' => 'Responsive',
                'icon' => 'desktop',
                'txt' => 'some thing to be said about that'
            ],
            (object)[
                'title' => 'Responsive',
                'icon' => 'desktop',
                'txt' => 'some thing to be said about that'
            ],
            (object)[
                'title' => 'Responsive',
                'icon' => 'desktop',
                'txt' => 'some thing to be said about that'
            ],
        ];

        return $this->view->render('home', [
            'pros' => $pros,
        ]);
    }
}
