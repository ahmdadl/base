<?php declare(strict_types=1);

namespace AppTest\Route;

use App\DIContainer;
use App\Route\Router;
use AppTest\AbstractTrait;
use PHPUnit\Framework\TestCase;
use Mockery;
use FastRoute\RouteCollector;
use App\Controllers\Home;
use App\Route\ErrorView;

class RouterTest extends TestCase
{
    const DEBUG = true;
    const CACHE_DIR = '/../../storage/tmp/';
    use AbstractTrait;

    private $routes;
    private $container;
    private $router;
    
    protected $homeCtrl;
    protected $errorView;

    public function setUp() : void
    {
        $this->container = Mockery::mock(DIContainer::class);
        $this->homeCtrl = Mockery::mock(Home::class);
        $this->errorView = Mockery::mock(ErrorView::class);
        
        $this->routes = function(RouteCollector $r) {
            $r->get('/ft/public/', ['Home@show']);
            $r->post('/ft/public/addUser', ['Home@addUser']);
            $r->put('/user/home', ['User@Home']);
            $r->delete('user/id/{id:\d+}', ['User@delete']);
            $r->addRoute(
                ['GET', 'POST'],
                '/ft/{up:[a-z]+}[/{name:[A-Z]+}]',
                ['Up@noWhere']
            );
        };
    }

    public function testCanInstanced() : void
    {
        $this->router = new Router(
            self::$request,
            self::$response,
            $this->container,
            self::DEBUG,
            dirname(__DIR__) . self::CACHE_DIR
        );

        $this->assertTrue(Mockery::type(DIContainer::class)->match($this->container));

        $this->assertInstanceOf(
            Router::class,
            $this->router
        );
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testSetRoutes() : void
    {
        $this->router = new Router(
            self::$request,
            self::$response,
            $this->container,
            self::DEBUG,
            dirname(__DIR__) . self::CACHE_DIR
        );

        $this->router->setRoutes($this->routes);
    }

    /**
     * @doesNotPerformAssertions
     * @dataProvider testRunWithFoundRouteData
     */
    public function testRunWithFoundRoute(
        string $method,
        string $uri,
        string $receiveHandler
    ) : void
    {
        self::$request->server->expects()
            ->get('REQUEST_METHOD')
            ->once()
            ->andReturn($method);
        self::$request->server->expects()
            ->get('REQUEST_URI')
            ->once()
            ->andReturn($uri);

        
        $this->homeCtrl->shouldReceive($receiveHandler)
            ->once()
            ->with(Mockery::any())
            ->andReturn($this->faker('randomHtml'));

        $this->container->expects()
            ->get(Mockery::any())
            ->atMost()
            ->twice()
            ->andReturn($this->homeCtrl);

        $this->router = new Router(
            self::$request,
            self::$response,
            $this->container,
            self::DEBUG,
            dirname(__DIR__) . self::CACHE_DIR
        );

        $this->router->setRoutes($this->routes);

        $this->router->run();
    }

    /**
     * @doesNotPerformAssertions
     * @dataProvider testRunWithNotFoundRouteData
     */
    public function testRunWithNotFoundRoute(
        string $method,
        string $uri,
        int $errCode = 404
    ) : void {
        self::$request->server->expects()
        ->get('REQUEST_METHOD')
        ->once()
        ->andReturn($method);
    self::$request->server->expects()
        ->get('REQUEST_URI')
        ->once()
        ->andReturn($uri);
        
        $this->homeCtrl->expects()
            ->show([])
            ->never();
        $this->errorView->expects()
            ->show($errCode)
            ->once()
            ->andReturn($this->faker('randomHtml'));

        $this->container->expects()
            ->get(Mockery::any())
            ->atLeast()
            ->once()
            ->andReturn($this->errorView);

        $this->router = new Router(
            self::$request,
            self::$response,
            $this->container,
            self::DEBUG,
            dirname(__DIR__) . self::CACHE_DIR
        );

        $this->router->setRoutes($this->routes);

        $this->router->run();
    }

    /**
     * @doesNotPerformAssertions
     * @return array
     */
    public function testRunWithFoundRouteData() : array
    {
        $defaultUri = '/ft/public/';
        return [
            'get' => ['GET', $defaultUri, 'show'],
            'post' => ['POST', $defaultUri . 'addUser', 'addUser'],
            'put' => ['PUT', '/user/home', 'Home'],
            'delete with id' => ['DELETE', 'user/id/55', 'delete'],
            'get with id and optinal name not used' => [
                'GET',
                '/ft/aheds',
                'noWhere'
            ],
            'post with id and optional name added' => [
                'POST',
                '/ft/ahmed/HOMES',
                'noWhere'
            ]
        ];
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testRunWithNotFoundRouteData() : array
    {
        return [
            'get' => ['GET', '/something', 404],
            'put method no allowed' => [
                'PUT',
                '/ft/public/',
                405
            ],
            'param with deferrent type' => [
                'DELETE',
                'user/id/5adh',
                404
            ],
            'optinal param with deffreient type' => [
                'POST',
                '/ft/ahmed/asd',
                404
            ],
            'get method not allwoed' => [
                'GET',
                '/user/home',
                405
            ]
        ];
    }
}