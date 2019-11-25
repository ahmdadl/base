<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Category;
use App\Models\Post;
use Symfony\Component\HttpFoundation\Request;
use App\View\FrontRenderInterface;
use App\Util\AppSession;
use App\Util\Filter;
use Hashids\Hashids;

class PostController extends BaseController
{
    use FileUploader;

    private $categoryModel;

    /**
     * upload dir based on root directory
     */
    const UPLOAD_DIR = 'storage/posts/';

    public function __construct(
        Request $request,
        FrontRenderInterface $view,
        Post $model,
        Hashids $hashids,
        AppSession $session,
        Category $categoryModel
    ) {
        parent::__construct($request, $view, $hashids, $session);
        $this->model = $model;
        $this->categoryModel = $categoryModel;
    }

    public function index()
    {
        return $this->view->render('post/index', [
            'posts' => $this->model->readAll(),
            'model' => $this->model,
            'pinned' => $this->model->pinnedPosts(),
            'cats' => $this->categoryModel->readAll(),
            'catModel' => $this->categoryModel
        ]);
    }

    public function create()
    {
        return $this->render('post/create');
    }

    public function save()
    {
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
        if (!$title || !Filter::len($title, 15)) {
            $error->title = true;
        } else {
            $old->title = $title;
        }

        // validate body
        if (!$body || !Filter::len($body, 150)) {
            $error->body = true;
        } else {
            $old->body = $body;
        }

        // check if image was enterd
        if (empty($_FILES['img']['name'])) {
            $error->file = true;
        }

        // if all data was entered corectly
        if (!$error->title || !$error->body || !$error->file) {
            $this->setUploader($_FILES['img']);

            // validate files
            $error->files = $this->validate(750, ['png', 'jpeg', 'jpg']);

            // file has error
            if ($error->files->size && $error->files->type) {
                // all data was validated

                // first upload image
                $img = $this->upload(self::UPLOAD_DIR);

                // check if file was not saved
                if (!$img) {
                    $error->uplading = false;
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
        }

        // add old variables
        $this->session->addFlash(
            'old',
            $old
        );

        $this->session->addFlash(
            'danger',
            $error
        );

        return $this->redirect('/blog/posts/create');
    }

    public function find()
    {
        $q = Filter::filterStr($this->request->get('q'));

        if (!$q) {
            return $this->redirect('/blog/posts/');
        }

        return $this->render('post/index', [
            'posts' => $this->model->findPosts($q),
            'model' => $this->model,
            'pinned' => $this->model->pinnedPosts(),
            'cats' => $this->categoryModel->readAll(),
            'catModel' => $this->categoryModel
        ]);
    }

    public function show(array $param)
    {
        if (!isset($param['slug']) || !Filter::filterStr($param['slug'])) {
            return $this->redirect('/404');
        }

        $slug = Filter::filterStr($param['slug']);

        $post = $this->model->readOne($slug);

        return $this->render('post/show', [
            'post' => $post,
            'model' => $this->model,
            'pinned' => $this->model->pinnedPosts(),
            'cats' => $this->categoryModel->readAll(),
            'catModel' => $this->categoryModel
        ]);
    }
}
