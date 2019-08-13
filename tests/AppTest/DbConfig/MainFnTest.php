<?php declare(strict_types=1);

namespace AppTest\DbConfig;

use App\DbConfig\MainFn;
use PHPUnit\Framework\TestCase;

final class MainFnTest extends TestCase
{
    protected $someClass;

    public function setUp() : void
    {
        $this->someClass = new class('test') extends MainFn {
            public function returnThis()
            {
                return $this;
            }

            protected function connect() : void 
            {
                $this->con = true;
            }
        };
    }

    public function testInstance() : void
    {
        $this->assertInstanceOf(
            MainFn::class,
            $this->someClass->returnThis()
        );
    }

    public function testIsLive() : void
    {
        $this->assertFalse($this->someClass->isLive());
    }

    public function testGetConnection() : void
    {
        $this->assertTrue(
            $this->someClass->getConnection()
        );
    }
}