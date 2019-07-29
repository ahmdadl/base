<?php declare (strict_types=1);

namespace App\Route;


use Symfony\Component\HttpFoundation\{
    Request,
    Response
};
use FastRoute\{
    RouteCollector,
    cachedDispatcher,
    Dispatcher as Code
};

class Router
{
    const CACHE_DIR = DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'route.cache';

    /**
     * HttpFoundation Request
     *
     * @var Request
     */
    private $request;
    /**
     * HttpFoundation Response
     *
     * @var Response
     */
    private $response;

    /**
     * DI contaniner to retrive controllers
     *
     * @var object
     */
    private $container;

    /**
     * fast-route dispatcher handler
     *
     * @var FastRoute
     */
    private $router;
    /**
     * Default FastRoute RouteCollector Function
     *
     * @var FastRoute\RouteCollector
     */
    private $routes;
    /**
     * FastRoute Options
     *
     * @var array
     */
    private $options = [];
    /**
     * Dispatched Route Info
     * used to extract controllers and middlewares
     *
     * @example [int => Dispatcher::HTTP_{Codes},
     * handler => ['className::methodname', 'middlewares' => [methods in the same controlller] ]]
     * 
     * @var FastRoute::dispatch[array]
     */
    private $routeInfo;

    /**
     * init class
     *
     * @param Request $request
     * @param Response $response
     * @param object $Dicontainer
     * @param boolean $isDebug
     */
    public function __construct(
        Request $request,
        Response $response,
        object $DIcontainer,
        bool $isDebug = false
    ) {
        $this->request = $request;
        $this->response = $response;
        $this->container = $DIcontainer;
        $this->setOptions($isDebug);
    }

    public function setRoutes($routes) : void
    {
        $this->routes = $routes;
    }

    public function run()
    {
        // first initialize fast-route with routes and options
        $this->instanc();
        // dispatch router
        $this->getRouteInfo();
        // validate current route
        $this->validateRoute();
    }

    private function setOptions(bool $isDebug) : void
    {
        if ($isDebug) {
            $this->options = [
                'cacheFile' => dirname(__DIR__) . self::CACHE_DIR,
                'cacheDisabled' => $isDebug
            ];
        }
    }

    private function instanc() : void
    {
        $this->router = \FastRoute\cachedDispatcher(
            $this->routes,
            $this->options
        );
    }

    private function getRouteInfo() : void
    {
        $this->routeInfo = $this->router->dispatch(
            $this->request->server->get('REQUEST_METHOD'),
            strtok($this->request->server->get('REQUEST_URI'), '?')
        );
    }

    /**
     * handle current route and extract className, method, args
     * and middlwares
     *
     * @return void
     */
    private function handleRoute() : void
    {
        // ClassName::methodName
        $r = preg_split('/\:\:/', $this->routeInfo[1][0], -1, PREG_SPLIT_NO_EMPTY);
        $method = $r[1];
        $args = $this->routeInfo[2];
        // var_dump($this->routeInfo[0]['middlewares']);
        
        // get the class from container
        $class = $this->container->get($r[0]);

        // check if there is any middlewares attached to that route
        if (isset($this->routeInfo[1]['middlewares'])) {
            // run these middlewares sorted as enterd in route []
            $args['error'] = $this->handleMiddlewares(
                $class,
                $this->routeInfo[1]['middlewares']
            );
        }
        // call method with route args
        $class->$method($args);
    }

    private function handleMiddlewares(
        object $class,
        array $middlewares
    ) : array {
        foreach ($middlewares as $fn) {
            $err = $class->$fn();
            if ($err['errCode']) return $err;
        }
        return ['error' => false];
    }

    private function validateRoute()
    {
        switch ($this->routeInfo[0]) {
            case Code::NOT_FOUND:
                (new \Main\Route\ErrorView(
                    $this->response,
                    $this->container->get('Router\ErrorRender')
                ))->show(404);
                break;
            case Code::METHOD_NOT_ALLOWED:
                (new \Main\Route\ErrorView(
                    $this->response,
                    $this->container->get('Router\ErrorRender')
                ))->show(405);
                break;
            case Code::FOUND:
                $this->handleRoute();
                break;
            default:
                (new \Main\Route\ErrorView(
                    $this->response,
                    $this->container->get('Router\ErrorRender')
                ))->show(404);
        }
    }

}