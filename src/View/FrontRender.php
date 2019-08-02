<?php declare (strict_types=1);

namespace App\View;

use Symfony\Component\HttpFoundation\{
    Request,
    Response
};
use App\Util\AppSession;
use League\Plates\Engine;
use League\Plates\Extension\{
    Asset,
    URI
};


class FrontRender implements FrontRenderInterface
{
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

    public function render(string $template, array $params = []) : void
    {
        $html = $this->view->render($template, $params);
        $this->response->setStatusCode(Response::HTTP_OK);
        $this->response->setContent($html);
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
        $this->view->registerFunction('es', function($str) {
            return htmlspecialchars(strip_tags(trim($str)), ENT_QUOTES);
        });

        // create method function like laravel one
        $this->view->registerFunction('_method', function ($me) {
            return '<input type="hidden" name="_method" value="' . $me . '" />';
        });


        // assign data to all views
        // check if there is user sign in or not
        $this->view->addData(['hasSession' => $this->request->hasPreviousSession()]);

        // make session available to all views
        $this->view->addData(['session' => $this->session]);
        

    }
}