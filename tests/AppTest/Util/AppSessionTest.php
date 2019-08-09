<?php declare(strict_types=1);

namespace AppTest\Util;

use PHPUnit\Framework\TestCase;
use App\Util\AppSession;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;

class AppSessionTest extends TestCase
{
    public $session;

    public function setUp() : void
    {
        $sessionMock = $this->createMock(Session::class);
        $requestMock = $this->createMock(Request::class);
        $this->session = $this->createMock(AppSession::class);
    }

    public function testInstance() : void
    {
        $this->assertInstanceOf(AppSession::class, $this->session);
    }

    // public function testSessStart() : void
    // {
    //     $this->assertEquals('asd', $this->session);
        
    // }
}