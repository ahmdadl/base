<?php declare (strict_types=1);

namespace App\Controllers;
use Symfony\Component\HttpFoundation\Request;
use DB\Model\HomeModel;
use App\View\FrontRenderInterface;
use DB\Model\UserModel;

class Joke
{
    /**
     * HttpFoundation Request
     *
     * @var Request
     */
    private $request;
    /**
     * joke model instance
     *
     * @var JokeModle
     */
    private $model;
    /**
     * Plates Template View
     *
     * @var FrontRender
     */
    private $view;

    private $user;

    public function __construct(
        Request $request,
        HomeModel $model,
        FrontRenderInterface $view,
        UserModel $user
    ) {
        $this->request = $request;
        $this->model = $model;
        $this->view = $view;
        $this->user = $user;
    }

    public function addNew() : void
    {
        // check if this is form submit
        if ($this->request->request->get('text')) {
            $this->model->text = $this->request->request->get('text');
            $this->model->authorID = $this->request->request->get('authorID');
            $data = $this->model->createOne() ? 'trueee' : 'falsess';
        }   

        $this->view->render('addnew', [
            'fine' => $data ?? '',
            'users' => $this->user->readAll()
        ]);
    }
}