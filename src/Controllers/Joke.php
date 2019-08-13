<?php declare (strict_types=1);

namespace App\Controllers;
use Symfony\Component\HttpFoundation\Request;
use DB\Model\HomeModel;
use App\View\FrontRenderInterface;
use DB\Model\UserModel;
use Hashids\Hashids;
use Symfony\Component\HttpFoundation\Response;

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
     * @var Joke
     */
    private $model;
    /**
     * User model instance
     *
     * @var User
     */
    private $user;
    /**
     * Plates Template View
     *
     * @var FrontRender
     */
    private $view;
    /**
     * hashid instance
     *
     * @var Hashids
     */
    private $hashid;

    public function __construct(
        Request $request,
        HomeModel $model,
        FrontRenderInterface $view,
        UserModel $user,
        Hashids $hashid
    ) {
        $this->request = $request;
        $this->model = $model;
        $this->view = $view;
        $this->user = $user;
        $this->hashid = $hashid;
        // $this->sess
    }

    public function addNew() : Response
    {
        // check if this is form submit
        if ($this->request->request->get('text')) {
            $this->model->text = $this->request->request->get('text');
            $this->model->authorID = $this->hashid->decode($this->request->request->get('authorID'))[0];
            $data = $this->model->createOne();
        }   

        return $this->view->render('addnew', [
            'edit' => false,
            'fine' => $data ?? '',
            'users' => $this->user->readAll(),
            'hashid' => $this->hashid
        ]);
    }

    public function edit(array $p) : Response
    {
        
        // decode joke id and assign it to model
        $id = $this->hashid->decode($p['id']);
        if (!isset($id[0])) {
            throw new \Exception('joke id is not vaild');
        }
        $this->model->id = $id[0];
        // check if user has submited the edit button
        if (!$this->request->request->has('text')) {
            // if user just visited the edit route then show joke
            $joke = $this->model->readOne();
        } else {
            // if user edited and submited joke then update joke
            $this->model->text = $this->request->request->get('text');
            $this->model->authorID = $this->hashid->decode($this->request->request->get('authorID'))[0];

            $data = $this->model->update();

            // create new object contain joke data 
            // better than reloading it from database
            $joke = new \stdClass();
            $joke->text = $this->request->request->get('text');
            $joke->id = $p['id'];
            $joke->authorID =$this->request->request->get('authorID');
        }

        return $this->view->render('addnew', [
            'edit' => true,
            'fine' => $data ?? '',
            'joke' => $joke,
            'users' => $this->user->readAll(),
            'hashid' => $this->hashid
        ]);
    }

    public function delete(array $param) : bool
    {
        $id = $this->hashid->decode($param['id']);

        if (!isset($id[0])) {
            throw new \Exception('joke id is not vaild');
        }
        
        $this->model->id = $id[0];

        return $this->model->delete();
    }
}