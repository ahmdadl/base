<?php declare (strict_types=1);

namespace App\View;

use Symfony\Component\HttpFoundation\{
    Request,
    Response
};
use App\Util\{
    AppSession,
    Password
};
use League\Plates\Engine;
use League\Plates\Extension\{
    Asset,
    URI
};
use App\View\FrontRenderTrait;
class FrontRender implements FrontRenderInterface
{
    use FrontRenderTrait;

    private $requset;
    private $response;
    private $view;
    private $session;

    public function __construct(
        Request $request,
        Response $response,
        Engine $view,
        AppSession $session
    ) {
        $this->request = $request;
        $this->response = $response;
        $this->view = $view;
        $this->session = $session;
        $this->configView();
    }

    public function render(string $template, array $params = []) : Response
    {
        return $this->response->setContent(
            $this->spaceless(
                $this->view->render($template, $params)
            )
        );
    }

    /**
     * config plates instance to load desired extension and functions
     *
     * @return void
     */
    private function configView() : void
    {
        // load Asset extension
        $this->view->loadExtension(new Asset(dirname(__DIR__) . '/../public/', true));

        // load URI extenssion
        $this->view->loadExtension(new URI($this->request->getPathInfo()));

        // create new escape function
        $this->view->registerFunction('es', [$this, 'es']);

        // create method function like laravel one
        $this->view->registerFunction('_method', [$this, '_method']);

        /**
         * create function to add csrf token
         * @link https://stackoverflow.com/questions/6287903/how-to-properly-add-csrf-token-using-php
         */
        $this->view->registerFunction('csrf', [$this, 'csrf']);

        // make session available to all views
        $this->view->addData(['session' => $this->session->se]);
    }
}