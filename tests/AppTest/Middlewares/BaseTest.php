<?php declare (strict_types=1);

namespace AppTest\Middlewares;

use App\Middlewares\Base;
use AppTest\AbstractTrait;
use PHPUnit\Framework\TestCase;
use Mockery;

final class BaseTest extends TestCase
{
    use AbstractTrait;

    protected $clss;
    protected $someClass;

    public function setUp() : void
    {
        self::$session->shouldReceive('sessStart')
        ->atMost()
        ->times(4)
        ->andReturnNull();
        
        $this->clss = new class(
            self::$request,
            self::$session
            ) extends Base {
            public function __construct($request, $session)
            {
                parent::__construct($request, $session);
                $session->sessStart();
            }

            public function process() : bool
            {
                return true;
            }

            public function returnThis()
            {
                return $this;
            }
        };

        $this->someClass = new $this->clss(
            self::$request,
            self::$session
        );
    }

    public function testInstance() : void
    {
        $this->assertInstanceOf(
            Base::class,
            $this->someClass->returnThis()
        );
    }

    public function testProcess() : void
    {
        $this->assertTrue(
            $this->someClass->process()
        );
    }
}