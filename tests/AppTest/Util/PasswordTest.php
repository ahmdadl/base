<?php declare(strict_types=1);

namespace AppTest\Util;

use App\Util\Password;
use PHPUnit\Framework\TestCase;

class PasswordTest extends TestCase
{
    public function testPushAndPop()
    {
        $stack = [];
        $this->assertSame(0, sizeof($stack));

        array_push($stack, 'foo');
        $this->assertSame('foo', $stack[sizeof($stack) -1]);
        $this->assertSame(1, sizeof($stack));

        $this->assertSame('foo', array_pop($stack));
        $this->assertSame(0, sizeof($stack));
    }

}