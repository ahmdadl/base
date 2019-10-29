<?php declare(strict_types = 1);

namespace App\Controllers;

use Symfony\Component\HttpFoundation\{
    Request,
    Response,
RedirectResponse
};
use App\View\FrontRenderInterface;
use Hashids\Hashids;
use App\Util\AppSession;
use App\Models\PostModel;
use Respect\Validation\Validator as v;

final class Post extends BaseController
{
    private $model;

    public function __construct(
        Request $request,
        FrontRenderInterface $view,
        Hashids $hashid,
        AppSession $session,
        PostModel $model
    ) {
        parent::__construct($request, $view, $hashid, $session);
        $this->model = $model;
    }

    public function getAll() : Response
    {
        return $this->view->render(
            'home',
            [
                'posts' => $this->model->readAll()
            ]
        );
    }

    public function getOne(array $param = []) : Response
    {
        $this->model->postId = $this->decode($param['id']);

        return $this->view->render(
            'post',
            [
                'post' => $this->model->readOne()
            ]
        );
    }

    public function edit(array $param) : Response
    {
        $wasVAlid = '';
        $errors = [
            'inp' => false
        ];
        
        $this->model->postId = $this->decode($param['id']);
        
        // check if edit form was submitted
        if ($this->request->request->has('submitEdit')) {

            $wasVAlid = 'was-validated';
            
            // validate title
            $validTitle = v::stringType()
                ->notEmpty()
                ->length(1, 50)
                ->validate($this->getRequest('title'));
            // validate content
            $validContent = v::stringType()
                ->notEmpty()
                ->length(1, 255)
                ->validate($this->getRequest('content'));

            // validate title
            if (!$validTitle || !$validContent) {
                $errors['inp'] = true;
                $this->session->addFlash(
                    'danger',
                    'an error occured'
                );
            } else {
                $this->model->title = $this->getRequest('title');
                $this->model->content = $this->getRequest('content');

                if ($this->model->updatePost()) {
                    $wasVAlid = '';
                    $this->session->addFlash(
                        'success',
                        'updated succeffully'
                    );
                }
            }
            
            $post = (object)[
                'title' => $this->getRequest('title'),
                'content' => $this->getRequest('content')
            ];
        } else {
            $post = $this->model->readOne();
        }

        return $this->view->render(
            'edit',
            [
                'post' => $post,
                'wasValid' => $wasVAlid,
                'err' => $errors
            ]
        );
    }

    public function deletePost(array $param) : void
    {
        $this->model->postId = $this->decode($param['id']);

        if ($this->model->deleteOne()) {
            (new RedirectResponse('/fc/public'))->send();
        }
    }
}