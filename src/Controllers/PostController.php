<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Post;
use Symfony\Component\HttpFoundation\Request;
use App\View\FrontRenderInterface;
use App\Util\AppSession;
use App\Util\Filter;
use Hashids\Hashids;
use Symfony\Component\HttpFoundation\Response;

class PostController extends BaseController
{
    use FileUploader;

    /**
     * upload dir based on root directory
     */
    const UPLOAD_DIR = 'storage/posts/';

    public function __construct(
        Request $request,
        FrontRenderInterface $view,
        Post $model,
        Hashids $hashids,
        AppSession $session
    ) {
        parent::__construct($request, $view, $hashids, $session);
        $this->model = $model;
    }

    public function index()
    {
        return $this->view->render('post/index', [
            // 'posts' => $this->model->readAll()
        ]);
    }

    public function create()
    {
        return $this->render('post/create');
    }

    public function save()
    {
        // print_r($_POST);
        $error = (object) [
            'title' => false,
            'body' => false,
            'file' => false,
            'files' => false,
            'uploading' => false,
            'saving' => false
        ];

        $old = (object) [
            'title' => '',
            'body' => ''
        ];

        $title = Filter::filterStr($this->request->get('title'));
        $body = Filter::filterStr($this->request->get('body'));

        // validate title
        if (!$title || !Filter::len($title, 10)) {
            $error->title = true;
        } else {
            $old->title = $title;
        }

        // validate body
        if (!$body || !Filter::len($body, 50)) {
            $error->body = true;
        } else {
            $old->body = $body;
        }

        // check if image was enterd
        if (empty($_FILES['img']['name'])) {
            $error->file = true;
        }

        // if all data was entered corectly
        if (!$error->title && !$error->body && !$error->file) {
            $this->setUploader($_FILES['img']);

            // validate files
            $error->files = $this->validate(2000, ['png', 'jpeg', 'jpg']);

            // file has error
            if ($error->files->size || $error->files->type) {
                // add flash session to show errors in next page
                // $this->session->addFlash(
                //     'danger',
                //     $error
                // );

                // return $this->create();
            } else {
                // all data was validated

                // first upload image
                $img = $this->upload(self::UPLOAD_DIR);

                // check if file was not saved
                if (!$img) {
                    $error->uplading = false;

                    // $this->session->addFlash(
                    //     'danger',
                    //     $error
                    // );

                    // return $this->create();
                } else {
                    // image uploaded succeffully

                    // save post
                    $this->model->title = $title;
                    $this->model->body = $body;
                    $this->model->img = $img;
                    $this->model->slug = str_replace(' ', '-', $title);

                    if (!$this->model->create()) {
                        $error->saving = true;
                    } else {
                        return $this->redirect('/blog/posts');
                    }
                }
            }
        } else {
            // add error variable is flash session


            // add old variables
            $this->session->addFlash(
                'old',
                $old
            );

            // return to last page
            // return (new RedirectResponse('/blog/posts/create'))->send();

        }

        $this->session->addFlash(
            'danger',
            $error
        );
        // return $this->create();
        return $this->redirect('/blog/posts/create');
        $this->session->se->set('name', 'ahmedAdel');

        echo $this->session->se->get('name');
    }
}
