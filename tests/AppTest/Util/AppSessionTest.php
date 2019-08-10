<?php declare(strict_types=1);

namespace AppTest\Util;

use PHPUnit\Framework\TestCase;
use App\Util\AppSession;
use Symfony\Component\HttpFoundation\{
    Request,
    RedirectResponse,
    ParameterBag,
    Session\Session,
    Session\Storage\MockArraySessionStorage
};
use Mockery;
use function GuzzleHttp\json_encode;

class AppSessionTest extends TestCase
{
    private $session;
    private $request;
    private $faker;

    public function setUp() : void
    {
        $sessionMock = new Session(new MockArraySessionStorage());
        
        $this->request = Mockery::mock(Request::class);
        $this->request->server = Mockery::mock(ParameterBag::class);

        $this->faker = new \Faker\Generator();
        $this->faker->addProvider(new \Faker\Provider\Internet($this->faker));
        $this->faker->addProvider(new \Faker\Provider\UserAgent($this->faker));
        $this->faker->addProvider(new \Faker\Provider\Lorem($this->faker));

        $this->session = new AppSession(
            $sessionMock,
            $this->request,
            1800 // 30 min
        );
    }

    public function tearDown() : void
    {
        // $this->session->se->clear();
        $this->request = null;
        $this->faker = null;
        Mockery::close();
    }

    public function testInstance() : void
    {
        $this->assertInstanceOf(AppSession::class, $this->session);
        $this->assertInstanceOf(Session::class, $this->session->se);
        $this->assertTrue(
            Mockery::type(Request::class)->match($this->request)
        );
    }

    public function testSessStart() : AppSession {
        // mock request server call
        $userIP = $this->faker->ipv4;
        $userAgent = $this->faker->chrome;
        // return user ip address
        $this->request->server->shouldReceive('get')
            ->with('REMOTE_ADDR')
            ->andReturn(
                $userIP, // inital with default
                $userIP, // first call
                $userIP, // unchanged IP
                $this->faker->ipv4 // change ip
            );
        // return user browser
        $this->request->server->shouldReceive('get')
            ->atMost()
            ->times(4)
            ->with('HTTP_USER_AGENT')
            ->andReturn(
                $userAgent, // test ip
                $userAgent, //test ip
                $userAgent, // test ip 
                $userAgent, // inital agent with defaut
                $userAgent, // unchanged agent
                $this->faker->firefox // change user browser
            );

        /**
         * start the session 
         * Will check for browser || IP change
         * and set the csrfToken 
         */
        $this->session->sessStart(); // iniate with default args

        // check if default session has been set
        $this->assertTrue($this->session->se->has('X_CSRF_TOKEN'));
        $this->assertTrue($this->session->se->has('Form_Token'));
        $this->assertEquals(
            AppSession::CHECK_BROWSER,
            $this->session->se->has('userAgent'),
            'userAgent session exists if it enabled'
        );
        $this->assertEquals(
            AppSession::CHECK_IP_ADDRESS,
            $this->session->se->has('userIP'),
            'userIP session exists if enabled'
        );

        return $this->session;
    }

    /**
     * @depends testSessStart
     */
    public function testUserIpKeepAndDestroySession(AppSession $sess)
    {
        $this->session = $sess;

        // enable check for ip address
        $this->session->sessStart(true,  false);
        $this->assertTrue($this->session->se->has('userIP'));
        $oldIP = $this->session->se->get('userIP');
        // set fake session
        $this->session->se->set('fake', $this->faker->word);

        // restart session with same ip address
        $this->session->sessStart(true, false);
        // check if ip session not changed
        $this->assertSame($oldIP, $this->session->se->get('userIP'));
        // check if old session still exists
        $this->assertTrue($this->session->se->has('fake'));

        // restart the session with deffrient ip
        $this->session->sessStart(true, false);
        // check if ip changed
        $this->assertNotEquals(
            $oldIP,
            $this->session->se->get('userIP')
        );
        // check if old session have destroyed
        $this->assertFalse($this->session->se->has('fake'));
    }

    /**
     * @depends testSessStart
     */
    public function testUserAgentKeepAndDestroySession(
        AppSession $sess
    ) : void {
        $this->session = $sess;
        
        // enable to check for user Browser
        $this->session->sessStart(false, true);
        $this->assertTrue($this->session->se->has('userAgent'));
        $oldAgent = $this->session->se->get('userAgent');
        // set fake data
        $this->session->se->set('fakeAgent', $this->faker->word);

        // restart session with same userAgent
        $this->session->sessStart(false, true);
        // check if ip session not changed
        $this->assertSame($oldAgent, $this->session->se->get('userAgent'));
        // check if old session still exists
        $this->assertTrue($this->session->se->has('fakeAgent'));

        // restart the session with deffrient userAgent
        $this->session->sessStart(false, true);
        // check if user Agent changed
        $this->assertNotEquals(
            $oldAgent,
            $this->session->se->get('userAgent')
        );
        // check if old session have destroyed
        $this->assertFalse($this->session->se->has('fakeAgent'));
    }

    /**
     * @depends testSessStart
     *
     * @param AppSession $sess
     * @return void
     */
    public function testCheckActivityDestroyingOrMegratingSession(AppSession $sess) : void {
        $this->session = $sess;

        // change default session maxlife to 1 sec
        $this->session->sessStart(false, false, 1);
        $this->session->se->set('name', $this->faker->word);
        $sessionID = $this->session->se->getId();

        /**
         * test if only the session id will change after maxlife
         * has passed but with user still active on website
         * 
         * @test Modify AppSession->checkActive() to invalidate
         * session after more than the maxlife period
         */
        // sleep(2);
        // $this->session->sessStart(false, false, 1);
        // $this->assertTrue($this->session->se->has('name'));
        // $this->assertNotEquals(
        //     $sessionID,
        //     $this->session->se->getId()
        // );

        sleep(2);
        $this->session->sessStart(false, false, 1);
        $this->assertFalse($this->session->se->has('name'));
        $this->assertNotEquals(
            $sessionID,
            $this->session->se->getId()
        );
    }

    /**
     * @depends testSessStart
     *
     * @return array
     */
    public function testSetCsrfToken(AppSession $sess) : void
    {
        $this->session = $sess;

        $this->session->sessStart(
            AppSession::CHECK_IP_ADDRESS,
            AppSession::CHECK_BROWSER,
            1
        );
        $csrfToken = $this->session->se->get('X_CSRF_TOKEN');
        $formToken = $this->session->se->get('Form_Token');

        $this->assertIsString($csrfToken);
        $this->assertIsString($formToken);

        // test no new tokens if old ones still active
        $this->session->sessStart();
        $this->assertSame(
            $csrfToken,
            $this->session->se->get('X_CSRF_TOKEN')
        );
        $this->assertSame(
            $formToken,
            $this->session->se->get('Form_Token')
        );

        // check if new tokens will be generated 
        // if session invalidated
        sleep(2);
        // restart session
        $this->session->sessStart(
            AppSession::CHECK_IP_ADDRESS,
            AppSession::CHECK_BROWSER,
            1
        );

        $this->assertNotEquals(
            $csrfToken,
            $this->session->se->get('X_CSRF_TOKEN')
        );
        $this->assertNotEquals(
            $formToken,
            $this->session->se->get('Form_Token')
        );
    }

    protected static function getMethod($name) {
        $class = new ReflectionClass('AppSession');
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }

    
}