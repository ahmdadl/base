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
    use HomeModelDataTrait;

    private $request;
    private $view;
    private $session;

    public function __construct(
        Request $request,
        FrontRenderInterface $view,
        AppSession $session
    ) {
        $this->request = $request;
        $this->view = $view;
        $this->session = $session;
        $this->session->sessStart();
    }

    public function show($params = [])
    {
        [$pros, $projects] = $this->getData();        

        return $this->view->render('home', [
            'pros' => $pros,
            'projects' => $projects
        ]);
    }
}
