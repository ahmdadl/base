<?php declare (strict_types=1);

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\View\FrontRenderInterface;
use DB\Model\UserModel;
use Hashids\Hashids;
use App\Util\AppSession;

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
    private $session;
    private $hashid;

    public function __construct(
        Request $request,
        UserModel $model,
        FrontRenderInterface $view,
        AppSession $session,
        Hashids $hashid
    ) {
        $this->request = $request;
        $this->model = $model;
        $this->view = $view;
        $this->session = $session;
        $this->hashid = $hashid;
        // start session and check for user browser and activty time
        $session->sessStart();
    }

    public function logIn(array $p = []) : void
    {
        // sleep(25);
        // var_dump($this->request->server->all());
        // var_dump($this->request->request);
        $data = [
            'nameReq' => false,
            'passReq' => false
        ];
        /**
         * check if form was submitted and 
         * no errors ocuured through middlewares
         */
        if ($this->request->request->has('submit')
        && !$p['error']) {
            // var_dump($l);
            // assign input to vars for simplicty
            $userName = $this->request->request->get('name');
            $userPass = $this->request->request->get('pass');
            // validate form inputs

            // check if name is not empty
            if (!$userName) {
                // send an required message to user view
                $this->session->se->getFlashBag()->add(
                    'danger',
                    'user name is required'
                );
                $data['nameReq'] = true;
            } else {
                $data['userName'] = $userName;
            }
            // check if password input not empty
            if (!$userPass) {
                $this->session->se->getFlashBag()->add(
                    'danger',
                    'user password is required'
                );
                $data['passReq'] = true;
            }

            // so check if name and password are corectly enterd
            if ($userName && $userPass) {
                // assign to modle properties
                // data filtaration will be at model
                $this->model->name = $userName;
                $this->model->pass = $userPass;
                // check if user exists and password  correct
                if ($this->model->checkUser()) {
                    $this->session->se->getFlashBag()->add(
                        'success',
                        'welcome '. $this->model->name
                    );

                    // iniate the proper sessions
                    $this->session->se->set('logedIn', true);
                    $this->session->se->set('userName', $this->model->name);
                    $this->session->se->set('userID', $this->model->id);
                } else {
                    $this->session->se->getFlashBag()->add(
                        'danger',
                        'user password or name is wrong'
                    );
                }
            }
        }
        $data['req'] = $this->request;
        // show login form
        // $this->view->render('logIn', $data);
        // var_dump('asd');
    }

    
}