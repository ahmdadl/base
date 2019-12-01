<?php declare (strict_types=1);

namespace App\Route;


use Symfony\Component\HttpFoundation\{
    Request,
    Response,
    RedirectResponse
};
use FastRoute\{
    RouteCollector,
    cachedDispatcher,
    Dispatcher as Code
};

class Router
{
    const CACHE_FILE = 'route.cache';

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
     * HttpFoundation redirect Response
     *
     * @var Redirectrespose
     */
    private $redirect;

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
        bool $isDebug = false,
        string $cacheDir
    ) {
        $this->request = $request;
        $this->response = $response;
        $this->container = $DIcontainer;
        $this->setOptions($isDebug, $cacheDir);
    }

    public function setRoutes(\Closure $routes) : void
    {
        $this->routes = $routes;
    }

    public function getRoutes() : \Closure
    {
        return $this->routes;
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

    private function setOptions(
        bool $isDebug,
        string $cacheDir
    ) : void {
        // var_dump($isDebug, $cacheDir, self::CACHE_FILE);
        $this->options = [
            'cacheFile' => $cacheDir . self::CACHE_FILE,
            'cacheDisabled' => $isDebug
        ];
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
        /**
         * split ClassName@methodName into CLassName and methodName
         */
        $r = preg_split('/@/', $this->routeInfo[1][0], -1, PREG_SPLIT_NO_EMPTY);
        $method = $r[1];
        $args = $this->routeInfo[2];
        
        /**
         * get the class from container
         * and prefix the class with App\Controllers\ + ClassName
         * because all routes will route to controllers any way
         */
        $class = $this->container->get('App\Controllers\\' . $r[0]);

        // check if there is any middlewares attached to that route
        if (isset($this->routeInfo[1]['middlewares'])) {
            // run these middlewares sorted as enterd in route array
            $args['error'] = $this->handleMiddlewares(
                $this->routeInfo[1]['middlewares']
            );
        }
        // call method with route args
        $class->$method($args);
    }

    private function handleMiddlewares(array $middlewares)
    {
        foreach ($middlewares as $cls) {
            $err = ($this->container->get('App\Middlewares\\' . $cls))->process();

            // check if middleware not passed
            if ($err) {
                // redirect to 403
                return (new RedirectResponse('/error/403'))->send();
            };
        }
        return false;
    }

    private function validateRoute()
    {
        switch ($this->routeInfo[0]) {
            case Code::NOT_FOUND:
                    ($this->container->get('App\Route\ErrorView'))->show(Response::HTTP_NOT_FOUND);
                break;
            case Code::METHOD_NOT_ALLOWED:
                ($this->container->get('App\Route\ErrorView'))->show(Response::HTTP_METHOD_NOT_ALLOWED);
                break;
            case Code::FOUND:
                $this->handleRoute();
                break;
        }
    }
}