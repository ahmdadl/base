<?php declare (strict_types=1);

namespace AppTest\Controllers;

use App\Util\AppSession;
use App\View\FrontRenderInterface;
use App\Controllers\Home;
use DB\Model\HomeModel;
use Mockery;
use Symfony\Component\HttpFoundation\Request;
use Hashids\Hashids;
use PHPUnit\Framework\TestCase;
use AppTest\AbstractTrait;

final class HomeTest extends TestCase
{
    use AbstractTrait;

    protected $view;
    protected $hashids;
    private $model;
    private $ctrl;

    public function setUp() : void
    {
        $this->view = Mockery::mock(FrontRenderInterface::class);
        $this->hashids = Mockery::mock(Hashids::class);
        $this->model = Mockery::mock(HomeModel::class);
        

        self::$session->shouldReceive('sessStart')
            ->once()
            ->withNoArgs()
            ->andReturn(Mockery::any());

        $this->ctrl = new Home(
            self::$request,
            $this->view,
            $this->model,
            $this->hashids,
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
        
        self::$response->shouldReceive('getContent')
            ->twice()
            ->passthru();

        $this->view->shouldReceive('render')
            ->once()
            ->andReturn(self::$response);
        
        $response = $this->ctrl->show();

        $this->assertSame(
            self::$response->getContent(),
            $response->getContent()
        );
    }
}