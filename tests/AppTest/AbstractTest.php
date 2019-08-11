<?php declare(strict_types=1);

namespace AppTest;

use PHPUnit\Framework\TestCase;
use Mockery;
use Faker\{
    Generator as Faker,
    Provider\ar_SA\Person,
    Provider\ar_SA\Address,
    Provider\en_US\PhoneNumber,
    Provider\ar_SA\Company,
    Provider\Lorem,
    Provider\Internet
};

class AbstractTest extends TestCase
{
    protected $faker;

    public function __construct()
    {
        $this->faker = new Faker();
        $this->faker->addProvider(new Person($this->faker));
        $this->faker->addProvider(new Address($this->faker));
        $this->faker->addProvider(new PhoneNumber($this->faker));
        $this->faker->addProvider(new Company($this->faker));
        $this->faker->addProvider(new Lorem($this->faker));
        $this->faker->addProvider(new Internet($this->faker));
    }
}