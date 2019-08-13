<?php declare(strict_types = 1);

namespace AppTest\DbConfig;

use App\DbConfig\MySqli;
use AppTest\AbstractTrait;
use PDO;
use PDOException;
use PHPUnit\Framework\TestCase;
use Mockery;

final class MySqliTest extends TestCase
{
    protected $mySqli;
    private $pdo;

    public function setUp() : void
    {
        $this->pdo = Mockery::mock(PDO::class);
    }

    public function testInstance() : void
    {
        $this->mySqli = new MySqli('test');

        $this->assertInstanceOf(
            MySqli::class,
            $this->mySqli
        );
    }

    public function testConnect() : void
    {
        $this->mySqli = new MySqli('test');

        $this->assertInstanceOf(
            PDO::class,
            $this->mySqli->getConnection()
        );
    }

    public function testErrorWithUnDefinedDataBase() : void
    {
        $this->mySqli = new MySqli('notAnDataBase');

        $this->expectException(PDOException::class);
        $this->mySqli->getConnection();
    }
    
}