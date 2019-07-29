<?php declare (strict_types=1);

namespace App\Controllers;
use Symfony\Component\HttpFoundation\Request;
use DB\Model\HomeModel;
use App\View\FrontRenderInterface;

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

    public function __construct(
        Request $request,
        HomeModel $model,
        FrontRenderInterface $view
    ) {
        $this->request = $request;
        $this->model = $model;
        $this->view = $view;
    }

    public function addNew() : void
    {
        // check if this is form submit
        if ($this->request->request->get('text')) {
            $this->model->text = $this->request->request->get('text');
            $this->model->authorID = $this->request->request->get('authorID');
            $data = $this->model->createOne() ? 'trueee' : 'falsess';
        }   

        $this->view->render('addnew', ['fine' => $data ?? '']);
    }
}