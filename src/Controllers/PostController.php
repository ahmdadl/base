<?php

declare(strict_types=1);

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;
use App\View\FrontRenderInterface;
use App\Util\AppSession;
use App\Util\Filter;

class PostController
{
    use FileUploader;

    /**
     * upload dir based on root directory
     */
    const UPLOAD_DIR = 'storage/posts/';

    private $request;
    private $view;
    private $session;
    private $model;

    public function __construct(
        Request $request,
        FrontRenderInterface $view,
        // HomeModel $model,
        AppSession $session
    ) {
        $this->request = $request;
        $this->view = $view;
        // $this->model = $model;
        $this->session = $session;
        $this->session->sessStart();
    }

    public function create()
    {
        return $this->view->render('post/create');
    }

    public function save()
    {
        $error = (object) [
            'title' => false,
            'body' => false,
            'file' => false,
            'uploading' => false
        ];

        $title = Filter::filterStr($this->request->get('title'));
        $body = Filter::filterStr($this->request->get('body'));

        // validate title
        if (!$title || !Filter::len($title, 10)) {
            $error->title = true;
        }

        // validate body
        if (!$body || !Filter::len($body, 50)) {
            $error->body = true;
        }

        // check if image was enterd
        if (empty($_FILES['img']['name'])) {
            $error->file = true;
        }

        // if all data was entered corectly
        if (!$error->title && !$error->body && !$error->file) {
            $this->setUploader($_FILES['img']);

            // validate files
            $error->files = $this->validate(125, ['png', 'jpeg', 'jpg']);

            // file has error
            if ($error->files->size || $error->files->type) {
                // add flash session to show errors in next page
                $this->session->addFlash(
                    'danger',
                    $error
                );

                return $this->create();
            } else {
                // all data was validated

                // first upload image
                $img = $this->upload(self::UPLOAD_DIR);

                // check if file was not saved
                if (!$img) {
                    $error->uplading = false;

                    $this->session->addFlash(
                        'danger',
                        $error
                    );

                    return $this->create();
                } else {
                    // image uploaded succeffully

                }
            }
        } else {
            $this->session->addFlash(
                'danger',
                $error
            );
            return $this->create();
        }
    }
}
