<?php declare (strict_types=1);

namespace AppTest\Handler;

use App\Custom;
use DB\Model\UserModel;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\{
    Request,
    Response
};
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Faker;

class CustomTest extends TestCase
{
    private $request;
    private $response;
    private $model;
    private $ctrl;
    private $session;
    private $faker;

    public function setUp() : void
    {
        $this->request = $this->getMockBuilder(Request::class)
                ->disableOriginalConstructor()
                ->getMock();
        $this->response = $this->getMockBuilder(Response::class)
                ->disableOriginalConstructor()
                ->getMock();
        
        $this->model = $this->getMockBuilder(UserModel::class)
                ->disableOriginalConstructor()
                ->getMock();
        
        $this->session = new Session(new MockArraySessionStorage());
        
        $this->ctrl = new Custom(
            $this->request,
            $this->response,
            $this->model
        );

        $this->faker = Faker\Factory::create();

    }

    public function tearDown() : void
    {
        $this->request = null;
        $this->response = null;
        $this->model = null;
        $this->ctrl = null;
    }

    public function testGetAll() : void
    {
        $user1 = new \stdClass;
        $user1->id = $this->faker->randomDigitNotNull;
        $user1->name = $this->faker->name;
        $user1->admin = 1;
        $user1->lastModified = $this->faker->dateTime;

        $user2 = new \stdClass;
        $user2->id = $this->faker->randomDigitNotNull;
        $user2->name = $this->faker->name;
        $user2->admin = 0;
        $user2->lastModified = $this->faker->dateTime;

        $users = [$user1, $user2];

        $this->model
            ->expects($this->once())
            ->method('readAll')
            ->will($this->returnValue($users));

        
        $result = $this->ctrl->getAll();
        
        $response = new Response(json_encode($users));

        $this->assertEquals($response, $result);

    }

    public function testGetOne()
    {
        $id = $this->faker->randomDigitNotNull;

        $a = new \stdClass();
        $a->id = $id;
        $a->name = $this->faker->name;
        $a->admin = 0;
        $a->lastModified = $this->faker->dateTime;

        $user = [$a];

        $this->model->id = $id;

        $this->model
            ->expects($this->once())
            ->method('readOne')
            ->will($this->returnValue($user));
        
        $result = $this->ctrl->getOne();

        $response = new Response(json_encode($user));

        $this->assertEquals($response, $result);
    }

    /**
     * @small
     */
    public function testGroupWorks()
    {
        $this->assertSame('a', 'a');
    }
    /**
     * @doesNotPerformAssertions
     *
     * @return void
     */
    public function testNoRisk()
    {
        $a = new Response('www');
    }

    public function testAddOrGetSession() : void
    {
        $this->session->set('some', 'no');
        $this->assertEquals(
            'no',
            $this->session->get('some')
        );
    }
}