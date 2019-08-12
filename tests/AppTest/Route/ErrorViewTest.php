<?php declare(strict_types=1);

namespace AppTest\Route;

use App\View\FrontRenderInterface;
use App\Route\ErrorView;
use AppTest\AbstractTrait;
use PHPUnit\Framework\TestCase;
use Mockery;

class ErrorViewTest extends TestCase
{
    use AbstractTrait;

    private $engine;

    public function setUp() : void
    {
        $this->engine = Mockery::mock(FrontRenderInterface::class);
    }

    public function testInstance() : void
    {
        $this->assertTrue(
            Mockery::type(FrontRenderInterface::class)->match($this->engine)
        );

        $errorView = new ErrorView($this->engine);

        $this->assertTrue(
            Mockery::type(ErrorView::class)->match($errorView)
        );
    }

    public function testShow() : void
    {
        $this->engine->expects()
            ->render('error/p404')
            ->once()
            ->andReturn(self::$response);
        
        $errorView = new ErrorView($this->engine);
        $this->assertNull($errorView->show(404));

        $this->engine->expects()
            ->render('error/p405')
            ->once()
            ->andReturn(self::$response);
        
        $errorView = new ErrorView($this->engine);
        $this->assertNull($errorView->show(405));
    }

}