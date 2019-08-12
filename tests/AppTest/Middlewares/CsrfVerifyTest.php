<?php declare(strict_types=1);

namespace AppTest\Middlewares;

use App\Middlewares\CsrfVerify;
use AppTest\AbstractTrait;
use PHPUnit\Framework\TestCase;
use Mockery;
use Symfony\Component\HttpFoundation\Session\Session;

final class CsrfVerifyTest extends TestCase
{
    use AbstractTrait;

    public function testInstance() : void
    {
        self::$session->expects()
            ->sessStart()
            ->once()
            ->andReturnNull();

        $csrfVerify = new CsrfVerify(
            self::$request,
            self::$session
        );

        $this->assertTrue(
            Mockery::type(CsrfVerify::class)->match($csrfVerify)
        );
    }

    public function testProcessWithVaildToken() : void
    {
        self::$session->expects()
            ->sessStart()
            ->once()
            ->andReturnNull();
        
        $token = $this->faker('sha256');
        
        self::$session->se->set('X_CSRF_TOKEN', $token);
        
        self::$request->request->expects()
            ->get('csrfToken')
            ->once()
            ->andReturn($token);

        $csrfVerify = new CsrfVerify(
            self::$request,
            self::$session
        );

        $this->assertFalse($csrfVerify->process());
    }

    public function testProcessWithInvalidToken() : void
    {
        self::$session->expects()
            ->sessStart()
            ->once()
            ->andReturnNull();
        
        self::$session->se->set(
            'X_CSRF_TOKEN',
            $this->faker('sha256')
        );
        
        self::$request->request->expects()
            ->get('csrfToken')
            ->once()
            ->andReturn($this->faker('sha256'));

        $csrfVerify = new CsrfVerify(
            self::$request,
            self::$session
        );

        $this->assertTrue($csrfVerify->process());

        $this->assertTrue(
            self::$session->se->getFlashBag()->has('danger')
        );
    }
}