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

final class HomeTest extends TestCase
{
    protected $request;
    protected $view;
    protected $hashids;
    protected $session;
    protected $faker;
    private $model;
    private $ctrl;

    public function setUp() : void
    {
        $this->request = Mockery::mock(Request::class);
        $this->view = Mockery::mock(FrontRenderInterface::class);
        $this->hashids = Mockery::mock(Hashids::class);
        $this->session = Mockery::mock(AppSession::class);
        $this->model = Mockery::mock(HomeModel::class);

        $this->faker = \Faker\Factory::create('ar_SA');
        

        $this->session->shouldReceive('sessStart')
            ->once()
            ->withNoArgs()
            ->andReturn(Mockery::any());

        $this->ctrl = new Home(
            $this->request,
            $this->view,
            $this->model,
            $this->hashids,
            $this->session
        );
    }

    public function testShow() : void
    {
        $posts = [
            [
                'id' => $this->faker->randomDigitNotNull,
                'authorID' => $this->faker->randomDigitNotNull,
                'text' => $this->faker->text,
                'updatedAt' => $this->faker->datetime
            ],
            [
                'id' => $this->faker->randomDigitNotNull,
                'authorID' => $this->faker->randomDigitNotNull,
                'text' => $this->faker->text,
                'updatedAt' => $this->faker->datetime
            ]
        ];
        $this->model->shouldReceive('readAll')
            ->once()
            ->withNoArgs()
            ->andReturn($posts);

        $this->view->shouldReceive('render')
            ->once()
            ->andReturn('asd');
        
        $response = $this->ctrl->show();

        $this->assertSame('asd', 'asd');
    }
}