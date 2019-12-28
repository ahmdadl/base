<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Admin;
use App\Util\AppSession;
use App\Util\Filter;
use app\Util\Password;
use App\View\FrontRenderInterface;
use Hashids\Hashids;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends BaseController
{
    use Auth;

    private $model;

    public function __construct(
        Request $request,
        FrontRenderInterface $view,
        Hashids $hashids,
        AppSession $session,
        Admin $model
    ) {
        parent::__construct($request, $view, $hashids, $session);
        $this->model = $model;
    }

    public function login()
    {
        if (
            (null !== $this->session->se->get('admin')) &&
            null !== $this->session->se->get('userName')
        ) {
            return $this->redirect('/blog/posts');
        }

        return $this->render('admin/login');
    }

    public function letMeIn()
    {
        $errors = (object) [
            'email' => false,
            'pass' => false,
            'exist' => false,
            'err' => false,
        ];

        $email = Filter::filterStr($this->post('email'));
        $pass = Filter::filterStr($this->post('password'));

        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors->email = true;
        }

        if (!$pass) {
            $errors->pass = true;
        }

        if (!$errors->email && !$errors->pass) {
            $this->model->email = $email;
            $this->model->password = $pass;

            $user = $this->model->checkUser();
            
            if (!$user) {
                $errors->exist = true;
            } else {
                if (Password::verify($pass, $user->password)) {
                    // user credntials is correct

                    $this->session->se->set('admin', true);
                    $this->session->se->set('userName', $user->name);
                    $this->session->se->set('userId', $user->id);
                    $this->session->se->set('userEmail', $user->email);

                    // redirect to all posts
                    return $this->redirect('/blog/posts');
                } else {
                    $errors->err = true;
                }
            }
        }

        $this->session->addFlash('danger', $errors);

        return $this->redirect('/root/login');
    }

    public function logOut()
    {
        $this->session->se->invalidate();
        return $this->redirect('/blog/posts');
    }
}
