<?php declare(strict_types = 1);

namespace AppTest\Controllers;

use App\Controllers\User;
use DB\Model\UserModel;
use PHPUnit\Framework\TestCase;
use Mockery;

final class UserTest extends TestCase
{
    use ControllersTrait;

    private $user;
    private $ctrl;

    public function setUp() : void
    {
        $this->user = Mockery::mock(UserModel::class);

        self::$view->shouldReceive('render')
            ->atMost()
            ->once()
            ->with('logIn', Mockery::any())
            ->byDefault()
            ->andReturn(self::$response);

        $this->ctrl = new User(
            self::$request,
            $this->user,
            self::$view,
            self::$session,
            self::$hashids
        );
    
    }

    public function testInstance() : void
    {
        $this->assertTrue(
            Mockery::type(User::class)->match($this->ctrl)
        );
    }

    public function testLogInWithoutFormSubmit() : void
    {
        
        self::$request->request->expects()
            ->has('submit')
            ->once()
            ->andReturn(false);

        $res = $this->ctrl->logIn();

        $this->assertSame(
            self::$response->getContent(),
            $res->getContent()
        );
    }

    public function testWithFormSubmitWithMiddleWareError() : void
    {
        self::$request->request->expects()
            ->has('submit')
            ->once()
            ->andReturn(true);

        $res = $this->ctrl->logIn(['error' => true]);

        $this->assertSame(
            self::$response->getContent(),
            $res->getContent()
        );
    }

    public function testLogInWithEmptyInputs():void
    {
        self::$request->request->expects()
            ->has('submit')
            ->once()
            ->andReturn(true);
        
        self::$request->request->expects()
            ->get('name')
            ->once()
            ->andReturn(false);
        self::$request->request->expects()
            ->get('pass')
            ->once()
            ->andReturn(false);

        $res = $this->ctrl->logIn(['error' => false]);

        $this->assertSame(
            self::$response->getContent(),
            $res->getContent()
        );

        $this->assertTrue(
            self::$session->se->getFlashBag()->has('danger')
        );

        $this->assertSame(
            self::$session->se->getFlashBag()->get('danger'),
            ['user name is required', 'user password is required']
        );
    }

    public function testLogInWithVaildInputsAndNotRegisteredUser() : void
    {
        self::$request->request->expects()
            ->has('submit')
            ->once()
            ->andReturn(true);
        
        self::$request->request->expects()
            ->get('name')
            ->once()
            ->andReturn($this->faker('name'));
        self::$request->request->expects()
            ->get('pass')
            ->once()
            ->andReturn($this->faker('password'));
        
        $this->user->expects()
            ->checkUser()
            ->once()
            ->andReturn(false);
        
        $res = $this->ctrl->logIn(['error' => false]);

        $this->assertSame(
            self::$response->getContent(),
            $res->getContent()
        );

        $this->assertTrue(
            self::$session->se->getFlashBag()->has('danger')
        );

        $this->assertSame(
            self::$session->se->getFlashBag()->get('danger'),
            ['user password or name is wrong']
        );
    }

    public function testLogInWithRegisteredUser() : void
    {
        $userName = $this->faker('name');
        
        self::$request->request->expects()
            ->has('submit')
            ->once()
            ->andReturn(true);

        self::$request->request->expects()
            ->get('name')
            ->once()
            ->andReturn($userName);
        self::$request->request->expects()
            ->get('pass')
            ->once()
            ->andReturn($this->faker('password'));

        $this->user->expects()
            ->checkUser()
            ->once()
            ->andReturn(true);
        
        $res = $this->ctrl->logIn(['error' => false]);

        $this->assertSame(
            self::$response->getContent(),
            $res->getContent()
        );

        $this->assertTrue(
            self::$session->se->getFlashBag()->has('success')
        );

        $this->assertSame(
            self::$session->se->getFlashBag()->get('success'),
            ['welcome ' . $userName]
        );
    }
}