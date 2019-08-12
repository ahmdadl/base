<?php declare (strict_types=1);

namespace AppTest;

use Faker\Factory;
use Mockery;
use League\Plates\Engine;
use Symfony\Component\HttpFoundation\{
    Request,
    Response,
    ParameterBag,
Session\Session,
Session\Storage\MockArraySessionStorage
};
use App\Util\AppSession;

trait AbstractTrait
{
    protected static $request;
    protected static $response;
    protected static $session;

    public static function setUpBeforeClass() : void
    {
        self::$request = Mockery::mock(Request::class);
        self::$request->server = Mockery::mock(ParameterBag::class);
        self::$request->request = Mockery::mock(ParameterBag::class);
        self::$response = Mockery::mock(Response::class);
        self::$session = Mockery::mock(AppSession::class);
        self::$session->se = new Session(new MockArraySessionStorage());
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