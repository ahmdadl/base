<?php declare(strict_types = 1);

namespace AppTest\Controllers;

use App\Controllers\User;
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
    use ControllersTrait;

    public function testSome() : void
    {
        self::$session->sessStart();
        $this->assertTrue(true);
    }
}