<?php declare (strict_types=1);

namespace AppTest\Controllers;

use App\Controllers\Home;
use DB\Model\HomeModel;
use Mockery;
use PHPUnit\Framework\TestCase;

final class HomeTest extends TestCase
{
    use ControllersTrait;

    private $model;
    private $ctrl;

    public function setUp() : void
    {
        $this->model = Mockery::mock(HomeModel::class);

        $this->ctrl = new Home(
            self::$request,
            self::$view,
            $this->model,
            self::$hashids,
            self::$session
        );
    }

    public function testShow() : void
    {
        $posts = [
            [
                'id' => $this->faker('randomDigitNotNull'),
                'authorID' => $this->faker('randomDigitNotNull'),
                'text' => $this->faker('text'),
                'updatedAt' => $this->faker('datetime')
            ],
            [
                'id' => $this->faker('randomDigitNotNull'),
                'authorID' => $this->faker('randomDigitNotNull'),
                'text' => $this->faker('text'),
                'updatedAt' => $this->faker('datetime')
            ]
        ];
        $this->model->shouldReceive('readAll')
            ->once()
            ->withNoArgs()
            ->andReturn($posts);
        
        self::$response->expects()
            ->setContent(Mockery::any())
            ->once()
            ->andReturn(self::$response->setContent($posts));

        self::$view->shouldReceive('render')
            ->once()
            ->andReturn(self::$response);
        
        $response = $this->ctrl->show();

        $this->assertSame(
            self::$response->getContent(),
            $response->getContent()
        );
    }
}