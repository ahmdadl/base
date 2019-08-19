<?php declare (strict_types=1);

namespace App;

use Whoops;
use App\Route\Router;
use App\DIContainer;

use Symfony\Component\HttpFoundation\{
    Request,
    Response,
    RedirectResponse
};

error_reporting(E_ALL);

/**
 * @codeCoverageIgnore
 */
class Bootstrap
{
    /**
     * configrations variables
     *
     * @var array
     */
    private $_config;
    /**
     * web routes
     *
     * @var array
     */
    private $routes;
    /**
     * Dependincy Injector Container
     *
     * @var Object
     */
    private $container;

    private $requset;
    private $response;

    public function __construct(array $config, object $routes)
    {
        $this->_config = $config;
        $this->routes = $routes;
    }

    /**
     * Run every thing
     *
     * @return void
     */
    public function run() : void
    {
        // init enviroment
        $this->envInit();
        // load the di container
        $this->loadContainer();
        // get the request from container
        $this->setRequest();
        // get the response from container
        $this->setResponse();
        // resolve current route
        $this->resolveRoutes();
        // send response
        $this->resolveResponse();
    }

    /**
     * resolve response based on enviroment
     * * development => will display all errors,
     * * production => never display error and log it instead,
     * * isDebugEnabled => will iniate whoops and show pritty errPage
     *
     * @return void
     */
    private function envInit() : void
    {
        if ($this->_config['isDebug']) {
            // iniate whoops and show error page
            $whoops = new Whoops\Run;
            $whoops->pushHandler(
                new Whoops\Handler\PrettyPageHandler
            );
            $whoops->register();
        } else {
            // set manual error handler
            set_exception_handler([$this, 'errHandler']);
            set_error_handler([$this, 'errHandler']);
        }

        if ($this->_config['env'] === 'dev') {
            $this->devENV();
        } else {
            $this->prodENV();
        }

    }

    /**
     * iniate router and set routes and resolve current route
     *
     * @return void
     */
    private function resolveRoutes() : void
    {
        // iniate router
        $router = new Router(
            $this->request,
            $this->response,
            $this->container,
            $this->_config['isDebug'],
            $this->_config['dir']['cache']
        );

        // set loaded routes
        $router->setRoutes($this->routes);

        // run router
        $router->run();
    }

    private function resolveResponse() : void
    {
        // fix http headers
        $this->response->prepare($this->request);
        // show response
        $this->response->send();
    }
    
    /**
     * load the Dependancy Injection Container file
     *
     * @return void
     */
    private function loadContainer() : void
    {
        $this->container = (new DIContainer($this->_config))->getContainer();
    }

    /**
     * get the htttpRequest
     *
     * @return Request
     */
    private function setRequest() : void
    {
        $this->request = $this->container->get(Request::class);
    }

    /**
     * get the httpResponse
     *
     * @return Response
     */
    private function setResponse() : void
    {
        $this->response = $this->container->get(Response::class);
    }

    /**
     * handle develpment enviroment to show all errors
     *
     * @return void
     */
    private function devENV() : void
    {
        ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
    }

    /**
     * hide and log errors on production enviroment
     * and set the error handler
     *
     * @return void
     */
    private function prodENV() : void
    {
        ini_set('display_errors', '0');
        ini_set('display_startup_errors', '0');
        ini_set('log_errors', '1');
        ini_set("error_log", dirname(__DIR__) . "/storage/log/error.log");
    }

    public function errHandler(
        $err,
        string $errstr = '',
        string $errfile = '',
        int $errline = 0
    )
    {
        // check if it an exception then handle it
        if (is_object($err)) {
            $errstr = $err->getMessage();
            $errfile = $err->getFile();
            $errline = $err->getLine();
            $err = $err->getCode();
        }

        /** @todo add mail function to email admin with errors */
        error_log("Error($err): inFile: $errfile atLine($errline) withMessage: $errstr");
        // redirect to unknownError route
        (new RedirectResponse('error'))->send();
    }
}







