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

    public function setUp() : void
    {
        $this->user = Mockery::mock(UserModel::class);
    }

    public function testInstance() : void
    {
        $ctrl = new User(
            self::$request,
            $this->user,
            self::$view,
            self::$session,
            self::$hashids
        );

        $this->assertTrue(
            Mockery::type(User::class)->match($ctrl)
        );
    }
}