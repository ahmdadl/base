<?php declare (strict_types=1);

namespace AppTest\Controllers;

use Mockery;
use Symfony\Component\HttpFoundation\Request;
use Hashids\Hashids;
use App\Util\AppSession;
use App\View\FrontRenderInterface;
use Faker\Generator as Faker;
use Faker\Provider\{
    Lorem,
    Internet,
    Base,
    ar_SA\Person,
    ar_SA\Address,
    en_US\PhoneNumber,
    ar_SA\Company
};
use PHPUnit\Framework\TestCase;

class BaseController extends TestCase
{
    protected $request;
    protected $view;
    protected $hashids;
    protected $session;
    protected $faker;

    public function setUp() : void
    {
        $this->request = Mockery::mock(Request::class);
        $this->view = Mockery::mock(FrontRenderInterface::class);
        $this->hashids = Mockery::mock(Hashids::class);
        $this->session = Mockery::mock(AppSession::class);

        $this->faker = new Faker();
        $this->faker->addProvider(new Person($this->faker));
        $this->faker->addProvider(new Address($this->faker));
        $this->faker->addProvider(new PhoneNumber($this->faker));
        $this->faker->addProvider(new Company($this->faker));
        $this->faker->addProvider(new Lorem($this->faker));
        $this->faker->addProvider(new Internet($this->faker));
    }

    public function tearDown() : void
    {
        Mockery::close();
        $this->request = null;
        $this->faker = null;
    }
}