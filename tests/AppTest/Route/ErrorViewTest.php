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
            Mockery::type(FrontRenderInterface::class)->type($this->engine)
        );

        $errorView = new ErrorView($this->engine);

        $this->assertTrue(
            Mockery::type(ErrorView::class)->type($errorView)
        );
    }

}