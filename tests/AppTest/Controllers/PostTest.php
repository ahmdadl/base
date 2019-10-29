<?php declare(strict_types = 1);

namespace AppTest\Controllers;

use AppTest\AbstractTrait;
use PHPUnit\Framework\TestCase;
use Mockery;
use App\Models\PostModel;
use App\Controllers\Post;
use Symfony\Component\HttpFoundation\Response;
use TypeError;
use Respect\Validation\Validator as v;
use Mockery\Mock;

final class PostTest extends TestCase{
    use ControllersTrait;

    private static $id;
    private static $post = [
        'title' => '',
        'content' => ''
    ];

    private static $resArgs = [
        'post' => [],
        'wasValid' => '',
        'err' => []
    ];

    private $model;
    private $ctrl;

    public function setUp() : void
    {
        $this->model = Mockery::mock(PostModel::class);

        // declate default post id
        self::$id = $this->faker('word');
        self::$resArgs['post'] = (object)self::$post;

        // declare default expections
        self::$hashids->shouldReceive()
            ->decode(Mockery::any())
            ->byDefault()
            ->atMost()
            ->once()
            ->andReturn([$this->faker('randomDigitNotNull')]);
        
        self::$request->request->shouldReceive()
            ->has('submitEdit')
            ->byDefault()
            ->atMost()
            ->twice()
            ->andReturn(true);
        
        self::$request->request->shouldReceive()
            ->get('title')
            ->byDefault()
            ->atMost()
            ->once()
            ->andReturn(self::$post['title']);
        self::$request->request->shouldReceive()
            ->get('content')
            ->byDefault()
            ->atMost()
            ->once()
            ->andReturn(self::$post['content']);

        
        $this->ctrl = new Post(
            self::$request,
            self::$view,
            self::$hashids,
            self::$session,
            $this->model
        );
    }

    public function testInstance() : void
    {
        $this->assertTrue(
            Mockery::type(PostModel::class)->match($this->model)
        );

        $this->assertInstanceOf(Post::class, $this->ctrl);
    }

    // public function testEditWithoutFormSubmit() : void
    // {
    //     $param['id'] = $this->faker('word');

    //     $post = (object)[
    //         'title' => $this->faker('sentence'),
    //         'content' => $this->faker('text')
    //     ];

    //     $renderArgs = [
    //         'post' => $post,
    //         'wasValid' => '',
    //          'errors' => []
    //     ];

    //     self::$request->request->shouldReceive()
    //         ->has('submitEdit')
    //         ->once()
    //         ->andReturn(false);
        
    //     $this->model->expects()
    //         ->readOne()
    //         ->once()
    //         ->andReturn($post);

    //     self::$view->shouldReceive('render')
    //         ->once()
    //         ->with('edit', $renderArgs)
    //         ->andReturn(new Response(''));

    //     $res = $this->ctrl->edit($param);

    //     $this->assertSame(
    //         (self::$view->render('edit', $renderArgs))->getContent(),
    //         $res->getContent()
    //     );
    // }

    public function testEditWithInvalidId() : void
    {
        $param['id'] = self::$id;
        
        self::$hashids->expects()
            ->decode($param['id'])
            ->once()
            ->passthru();
        
        $this->expectException(TypeError::class);
        
        $this->ctrl->edit($param);
    }

    public function testEditWithInvalidInput() : void
    {
        $param['id'] = self::$id;
        
        self::$resArgs['err']['inp'] = true;
        self::$resArgs['wasValid'] = 'was-validated';

        self::$session->shouldReceive()
        ->addFlash('danger', Mockery::any())
        ->once();

        self::$view->shouldReceive('render')
            ->once()
            ->with('edit', self::$resArgs)
            ->andReturn(new Response(''));
        
        $res = $this->ctrl->edit($param);

        $this->assertEquals(
            self::$view->render('edit', self::$resArgs),
            $res
        );
    }

    public function testEdit() : void
    {
        $param['id'] = self::$id;

        self::$post = [
            'title' => $this->faker('sentence'),
            'content' => $this->faker('text')
        ];
        self::$resArgs['post'] = (object)self::$post;
        self::$resArgs['err']['inp'] = false;

        $this->model->shouldReceive()
            ->updatePost()
            ->atMost()
            ->once()
            ->andReturn(true);

        self::$session->shouldReceive()
            ->addFlash('success', Mockery::any())
            ->once()
            ->andReturnNull();
        
        self::$view->shouldReceive()
            ->render('edit', self::$resArgs)
            ->once()
            ->andReturn(new Response(''));
        
        $res = $this->ctrl->edit($param);

        $this->assertEquals(
            (self::$view->render('edit', self::$resArgs))->getContent(),
            $res->getContent()
        );
    }
}