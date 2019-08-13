<?php declare(strict_types = 1);

namespace AppTest\Controllers;

use App\Controllers\Joke;
use DB\Model\HomeModel;
use DB\Model\UserModel;
use PHPUnit\Framework\TestCase;
use Mockery;
use stdClass;

class JokeTest extends TestCase
{
    use ControllersTrait;

    private $joke;
    private $user;
    private $ctrl;

    public function setUp() : void
    {
        $this->joke = Mockery::mock(HomeModel::class);
        $this->user = Mockery::mock(UserModel::class);

        $this->ctrl = new Joke(
            self::$request,
            $this->joke,
            self::$view,
            $this->user,
            self::$hashids
        );

        $this->user->shouldReceive('readAll')
            ->atMost()
            ->times(5)
            ->withNoArgs()
            ->andReturn([]);
    }

    public function testInstance() : void
    {
        $this->assertTrue(
            Mockery::type(HomeModel::class)->match($this->joke)
        );

        $this->assertTrue(
            Mockery::type(UserModel::class)->match($this->user)
        );

        $this->assertTrue(
            Mockery::type(Joke::class)->match($this->ctrl)
        );
    }

    public function testAddNewWithoutFormSubmit() : void
    {
        self::$request->request->expects()
            ->get('text')
            ->once()
            ->andReturn(false);
        
        self::$view->expects()
            ->render('addnew', Mockery::any())
            ->once()
            ->andReturn(self::$response);

        $res = $this->ctrl->addNew();

        $this->assertSame(
            self::$response->getContent(),
            $res->getContent()
        );
    }

    public function testAddNewWithFormSubmit() : void
    {
        $name = $this->faker('name');
        $hash = $this->faker('password');
        $successArray = [
            'edit' => false,
            'fine' => true,
            'users' => $this->user->readAll(),
            'hashid' => self::$hashids
        ];
        // copy success array without modifing it
        $errorArray = array_splice($successArray, 0, 0);
        $errorArray['fine'] = false;

        self::$request->request->expects()
            ->get('text')
            ->twice()
            ->andReturn($name);
        self::$request->request->expects()
            ->get('authorID')
            ->twice()
            ->andReturn($hash);
        
        self::$hashids->expects()
            ->decode($hash)
            ->twice()
            ->andReturn([1]);
        
        $this->joke->expects()
            ->createOne()
            ->atMost()
            ->twice()
            ->andReturn(true, false);
        
        // expect render with success on createOne joke
        self::$view->expects()
            ->render('addnew', $successArray)
            ->once()
            ->andReturn(self::$response);
        
        $successResponse = $this->ctrl->addNew();
        $this->assertSame(
            self::$response->getContent(),
            $successResponse->getContent()
        );

        // expect render with false on createOne joke
        self::$view->expects()
            ->render('addnew', $errorArray)
            ->once()
            ->andReturn(self::$response);
        
        $errorResponse = $this->ctrl->addNew();

        $this->assertSame(
            self::$response->getContent(),
            $errorResponse->getContent()
        );
    }

    public function testEditWithInvalidId() : void
    {
        $this->expectExceptionMessage('joke id is not vaild');

        self::$hashids->expects()
            ->decode(Mockery::any())
            ->once()
            ->andReturn([]);
        
        $this->ctrl->edit(['id' => 'w']);
    }

    public function testEditWithoutFormSubmit() : array
    {
        $joke = new stdClass;
        $joke->id = $this->faker('randomDigitNotNull');
        $joke->text = $this->faker('text');
        $joke->lastUpdated = $this->faker('datetime');

        $responseArray = [
            'edit' => true,
            'fine' => '',
            'joke' => $joke,
            'users' => $this->user->readAll(),
            'hashid' => self::$hashids
        ];

        self::$hashids->expects()
            ->decode($joke->text)
            ->once()
            ->andReturn([$joke->id]);
        
        self::$request->request->expects()
            ->has('text')
            ->once()
            ->andReturn(false);
        
        $this->joke->expects()
            ->readOne()
            ->once()
            ->andReturn(new stdClass);
        
        self::$view->expects()
            ->render('addnew', $responseArray)
            ->once()
            ->andReturn(self::$response);
        
        $res = $this->ctrl->edit(['id' => $joke->text]);

        $this->assertSame(
            self::$response->getContent(),
            $res->getContent()
        );

        return [$joke, $responseArray];
    }

    /**
     * @depends testEditWithoutFormSubmit
     *
     * @return void
     */
    public function testEditWithSubmitedForm(array $args) : void
    {
        [$joke, $responseArray] = $args;

        self::$hashids->expects()
            ->decode(Mockery::any())
            ->once()
            ->andReturn([$joke->id]);

        self::$request->request->expects()
            ->has('text')
            ->twice()
            ->andReturn(true, true);
        
        self::$request->request->expects()
            ->get('text')
            ->atMost()
            ->times(4)
            ->andReturn($joke->text);
        self::$request->request->expects()
            ->get('authorID')
            ->atMost()
            ->times(4)
            ->andReturn($joke->text);
        
        self::$hashids->expects()
            ->decode($joke->text)
            ->atMost()
            ->twice()
            ->andReturn([$joke->id]);
        
        $this->joke->shouldReceive('update')
            ->atMost()
            ->times(3)
            ->andReturn(true, false);
            
        $isComplete = $this->joke->update();
        $responseArray['fine'] = $isComplete;
        
        self::$view->expects()
            ->render('addnew', $responseArray)
            ->twice()
            ->andReturn(self::$response);
        
        $res = $this->ctrl->edit(['id' => $joke->text]);

        $this->assertSame(
            self::$response->getContent(),
            $res->getContent()
        );

        $res = $this->ctrl->edit(['id' => $joke->text]);

        $this->assertSame(
            self::$response->getContent(),
            $res->getContent()
        );
    }

    public function testDeleteWithInvaildJokeId() : void
    {
        $this->expectExceptionMessage('joke id is not vaild');

        self::$hashids->expects()
            ->decode('w')
            ->once()
            ->andReturn([]);
        
        $this->ctrl->delete(['id' => 'w']);
    }

    public function testDelete() : void
    {
        $hashedId = $this->faker('word');

        self::$hashids->expects()
            ->decode($hashedId)
            ->twice()
            ->andReturn([$this->faker('randomDigitNotNull')]);
        
        $this->joke->expects()
            ->delete()
            ->twice()
            ->andReturn(true, false);
        
        $this->assertTrue(
            $this->ctrl->delete(['id' => $hashedId])
        );

        $this->assertFalse(
            $this->ctrl->delete(['id' => $hashedId])
        );
    }
    
}