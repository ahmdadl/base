<?php declare(strict_types = 1);

namespace AppTest\Controllers;

use App\Util\AppSession;
use App\View\FrontRenderInterface;
use Faker\Factory;
use Mockery;
use Symfony\Component\HttpFoundation\{
    Request,
    Response,
    ParameterBag,
    Session\Session,
    Session\Storage\MockArraySessionStorage
};
use Hashids\Hashids;

trait ControllersTrait
{
    protected static $request;
    protected static $response;
    protected static $session;
    protected static $view;
    protected static $hashids;

    public static function setUpBeforeClass() : void
    {
        self::$request = Mockery::mock(Request::class);
        self::$request->server = Mockery::mock(ParameterBag::class);
        self::$request->request = Mockery::mock(ParameterBag::class);

        self::$response = Mockery::mock(Response::class);

        self::$session = Mockery::mock(AppSession::class);
        self::$session->se = new Session(new MockArraySessionStorage());

        self::$view = Mockery::mock(FrontRenderInterface::class);

        self::$hashids = Mockery::mock(Hashids::class);
    }

    public function tearDown() : void
    {
        Mockery::close();
    }

    public function faker($prop)
    {
        return (Factory::create('ar_SA'))->$prop;
    }
}