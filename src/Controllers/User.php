<?php declare (strict_types=1);

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;
use App\View\FrontRenderInterface;
use DB\Model\UserModel;

class User
{
    /**
     * User database model instance
     *
     * @var PDO
     */
    private $model;
    /**
     * HttpFoundation Request
     *
     * @var HttpRequest
     */
    private $request;
    /**
     * Template Parser instance
     *
     * @var FrontRender
     */
    private $view;

    public function __construct(
        Request $request,
        UserModel $model,
        FrontRenderInterface $view
    ) {
        $this->request = $request;
        $this->model = $model;
        $this->view = $view;
    }

    public function logIn() : void
    {

    }

    
}