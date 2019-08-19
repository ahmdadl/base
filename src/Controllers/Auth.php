<?php declare(strict_types = 1);

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;
use App\View\FrontRenderInterface;
use Hashids\Hashids;
use App\Util\AppSession;
use App\Models\AuthorModel;
use Symfony\Component\HttpFoundation\Response;
use app\Util\Password;
use PDOException;
use App\DbConfig\MySqli;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Auth extends BaseController{
    const REMEMBER_ME_COOKIE = 'localhostFcRemmberMe';

    private $model;
    private $response;

    public function __construct(
        Request $request,
        Response $response,
        FrontRenderInterface $view,
        Hashids $hashid,
        AppSession $session,
        AuthorModel $model
    ) {
        parent::__construct($request, $view, $hashid, $session);
        $this->model = $model;
        $this->response = $response;
    }

    public function logIn(array $param = [])
    {
        // check if user already signed in
        if ($this->session->get('logIn')) {
            // return (new RedirectResponse('/fc/public/'))->send();
        } elseif (null !== $this->getRequest('localhostFcRemmberMe', 'cookies')) {
            // var_dump(Cookie::fromString(
            //     ,
            //     true
            // ));
            var_dump($this->request->cookies->all());
        }

        $errors = [
            'userSn' => 0,
            'pass' => 0
        ];
        $vars = [
            'userSn' => ''
        ];

        // check if login form was submitted
        if ($this->request->request->has('submit')) {
            // iniat all inputs
            // if input not set or empty will return null
            $userSn = $this->getRequest('userSn');
            $pass = $this->getRequest('userPass');
            $remmberMe = $this->getRequest('remmberMe');

            // attatch old input to be used in view
            $vars = [
                'userSn' => $userSn
            ];

            $wasValid = 'was-validated';

            // check for user name input
            if (!$userSn) {
               $errors['userSn'] = 1;
            } elseif (!$pass || strlen($pass) < 6) {
                $pass = 0;
                $errors['pass'] = 1;
            }

            if ($userSn && $pass) {
                $this->model->userSn = $userSn;

                $row = $this->model->readOne();

                // check if no user found
                if (isset($row->size)) {
                    // show flash session for no user registerd
                    $this->session->addFlash(
                        'danger',
                        'invalid user name or password'
                    );
                } else {
                    // check if user password matche
                    if (Password::verify($pass, $row->userPass)) {
                        // check if password needs rehash
                        if (Password::checkReHash($row->userPass)) {
                            /** @todo update old user password */
                        }

                        $this->session->set('logIn', true);
                        $this->session->set('userId', $row->userId);
                        $this->session->set(
                            'userSn',
                            $row->screenName
                        );

                        // check if user checked remmber Me switch
                        if ($remmberMe) {
                            if (null === $this->getRequest(
                                self::REMEMBER_ME_COOKIE,
                                'cookies'
                            )) {
                                // add one time crypto as cookie
                                $this->response->headers->setCookie(
                                    Cookie::create(
                                        self::REMEMBER_ME_COOKIE,
                                        Password::randStr(),
                                        strtotime('+72 hours'),
                                        '/', null, false, true,
                                        false, 'Strict'
                                    )
                                );
                            }
                        }

                        // show flash session with success message
                        $this->session->addFlash(
                            'success',
                            'user loged in successfully.
                            <br> welcome ' . $row->userName
                        );
                    } else {
                        // user login failed
                        $this->session->addFlash(
                            'danger',
                            'invalid user name or password'
                        );
                    }
                }
            }
        }

        $param['wasValid'] = $wasValid ?? '';
        $param['errors'] = $errors;
        $param['vars'] = (object)$vars;

        $this->show([
            'temp' => 'logIn',
            'data' => $param
        ]);
    }

    public function signUp(array $param = [])
    {
        $errors = [
            'name' => 0,
            'email' => 0,
            'userSn' => 0,
            'pass' => 0
        ];
        $vars = [
            'name' => '',
            'email' => '',
            'userSn' => '',
            'pass' => ''
        ];

        if ($this->request->request->has('submit')) {
            // iniat all inputs
            // if input not set or empty will return null
            $userName = $this->getRequest('userName');
            $email = $this->getRequest('userEmail');
            $userSn = $this->getRequest('userSn');
            $pass = $this->getRequest('confPass');

            // attatch old input to be used in view
            $vars = [
                'name' => $userName,
                'email' => $email,
                'userSn' => $userSn,
                'pass' => $pass
            ];

            // handle was-validated bootstrap class
            $wasValid = true;

            // check for user name input
            if (!$userName) {
                $errors['name'] = 1;
            } elseif (!$email
            || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 1;
            } elseif (!$userSn) {
               $errors['userSn'] = 1;
            } elseif (!$pass || strlen($pass) < 6) {
                $pass = 0;
                $errors['pass'] = 1;
            }

            // check that every thing is fine
            if ($userName && $email && $userSn && $pass) {
                // assign data to mode to filer and save
                $this->model->userName = $userName;
                $this->model->userSn = $userSn;
                $this->model->email = $email;
                $this->model->userPass = Password::encode($pass);

                try {
                    if ($this->model->createOne()) {
                        $this->session->addFlash(
                            'success',
                            'user saved succesfully go to Home<a href="/fc/public/" class="btn btn-outline-primary">Home</a>'
                        );
                    }
                } catch(PDOException $e){
                    // check if it`s Duplicate entry Error
                    if ($e->errorInfo[1] === MySqli::MYSQL_CODE_DUPLICATE_KEY) {
                        // extract column name from error message
                        if (preg_match(
                            "/.*for\skey\s\'([a-zA-Z0-9]+)\'$/",
                            $e->errorInfo[2],
                            $matches
                            )) {
                            $dubCol = $matches[1];
                            if ($dubCol === 'screenName') {
                                $this->session->addFlash(
                                    'danger',
                                    'LogIn name already used before, please try to log in'
                                );
                            } else {
                                $this->session->addFlash(
                                    'danger',
                                    'email already used before, please try to log in'
                                );
                            }
                        }

                    } else {
                        $this->session->addFlash(
                            'danger',
                            'an error occured, please try again later'
                        );
                    } 
                }  
            }

            
        }

        $param['wasValid'] = $wasValid ?? '';
        $param['errors'] = $errors;
        $param['vars'] = (object)$vars;

        $this->show([
            'temp' => 'signUp',
            'data' => $param
        ]);
    }
    

    public function show(array $param = []) : Response
    {
        return $this->view->render($param['temp'], $param['data']);
    }
}