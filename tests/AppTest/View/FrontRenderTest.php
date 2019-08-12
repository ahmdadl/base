<?php declare (strict_types=1);

namespace AppTest\View;

use AppTest\AbstractTrait;
use App\View\FrontRender;
use Mockery;
use PHPUnit\Framework\TestCase;
use League\Plates\Engine;
use Symfony\Component\HttpFoundation\{
    Request,
    Response
};
use App\Util\AppSession;
use App\Util\Password;
use League\Plates\Extension\ExtensionInterface;

class FrontRenderTest extends TestCase
{
    use AbstractTrait;
    use FrontRenderTrait;

    private $engine;

    public function setUp() : void
    {
        $this->engine = Mockery::mock(Engine::class);
        $this->engine->shouldReceive('loadExtension')
            ->atMost()
            ->twice()
            ->andReturn(ExtensionInterface::class);

        self::$request->shouldReceive('getPathInfo')
            ->atMost()
            ->once()
            ->andReturn('/ft/public/');
        
        $this->engine->shouldReceive('registerFunction')
            ->atMost()
            ->times(3)
            ->byDefault()
            ->andReturn(
                $this->es('some')
            );
        
        $this->engine->shouldReceive('addData')
            ->atMost()
            ->once()
            ->andReturn(Engine::class);
    }
    
    public function testCanBeInstanced()
    {
        $frontRender = new FrontRender(
            self::$request,
            self::$response,
            $this->engine,
            self::$session
        );

        $this->assertTrue(
            Mockery::type(Request::class)->match(self::$request)
        );
        $this->asserttrue(
            Mockery::type(Response::class)->match(self::$response)
        );
        $this->assertTrue(
            Mockery::type(Engine::class)->match($this->engine)
        );
        $this->assertTrue(
            Mockery::type(AppSession::class)->match(self::$session)
        );
        $this->assertTrue(
            Mockery::type(FrontRender::class)->match($frontRender)
        );
    }

    public function testRender()  : void
    {
        $template = $this->faker('word');
        $param = [
            'name' => $this->faker('name'),
            'id' => $this->faker('randomDigitNotNull'),
        ];
        $content = $this->faker('randomHtml');

        $this->engine->expects()
            ->render($template, $param)
            ->once()
            ->andReturn($content);
        
        self::$response->expects()
            ->setContent($content)
            ->once()
            ->passthru();
        
        $frontRender = new FrontRender(
            self::$request,
            self::$response,
            $this->engine,
            self::$session
        );
        
        $res = $frontRender->render($template, $param);

        $this->assertTrue(
            Mockery::type(Response::class)->match($res)
        );

        $this->assertSame(
            self::$response->setContent($content),
            $res
        );
    }

    /**
     * @dataProvider testEsData
     * @group testRegisteredFunctions
     */
    public function testEs(string $expected, $actual) : void
    {
        $this->assertSame($expected, $this->es($actual));
    }

    /**
     * @dataProvider testMethodData
     * @group testRegisteredFunctions
     * @param string $expected
     * @param string $actual
     * @return void
     */
    public function testMethod(
        string $expected,
        string $actual
    ) : void {
        $actual = ('' === $actual) ? $this->_method() : $this->_method($actual);
        $this->assertSame($expected, $actual);
    }

    /**
     * @group testRegisteredFunctions
     * @param string $expected
     * @param string $actual
     * @return void
     */
    public function testCsrf() : void {

        $input = function (string $token) {
            return '<input type="hidden" name="csrfToken" value="' .
            $token . '" />';
        };

        // test will return nothing if no csrf token exists
        $this->assertEmpty($this->csrf());
        // will return as expected regaredless to exitst of formToken
        $this->assertNotEmpty($this->csrf($this->faker('url')));

        // set random tokens
        $csrfToken = $this->faker('sha256');
        $formToken = $this->faker('password');
        self::$session->se->set(
            'X_CSRF_TOKEN',
            $csrfToken
        );
        self::$session->se->set(
            'Form_Token',
            $formToken
        );

        $this->assertSame(
            $input($csrfToken),
            $this->csrf()
        );

        $key = $this->faker('word');
        $generatedFormToken = Password::hashMac($key, $formToken);
        
        $this->assertSame(
            $input($generatedFormToken),
            $this->csrf($key) 
        );
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testEsData() : array
    {
        $word = $this->faker('word');
        return [
            'empty' => ['', ''],
            'float' => ['123.5', 123.5],
            'normal string' => [$word, $word],
            'script tag' => [
                'alert(&quot;ww&quot;);',
                '<script>alert("ww");</script>',
            ],
            'html code' => [
                $word,
                '<p><span>'.$word.'</span></p>'
            ]
        ];
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testMethodData() : array
    {
        $before = '<input type="hidden" name="_method" value="';
        $after = '" />';
        return [
            'empty' => [
                $before.'POST'.$after,
                ''
            ],
            'get' => [
                $before.'GET'.$after,
                'get'
            ],
            'post' => [
                $before.'POST'.$after,
                'post'
            ],
            'put' => [
                $before.'PUT'.$after,
                'put'
            ],
            'delete' => [
                $before.'DELETE'.$after,
                'delete'
            ]
        ];
    }
}