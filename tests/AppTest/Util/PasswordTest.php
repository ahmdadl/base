<?php declare(strict_types=1);

namespace AppTest\Util;

use App\Util\Password;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\Stub\Exception;

class PasswordTest extends TestCase
{

    private $pass;

    public function setUp(): void
    {
        $this->pass = 'some thing 0155 4asdsad';
    }

    public function testEncode() : string
    {
        $encoded = Password::encode($this->pass);
        $this->assertRegExp("/[a-zA-Z0-9]/", $encoded);
        $this->assertIsString($encoded);
        $this->assertEquals(96, strlen($encoded));
        $this->assertIsString(
            Password::encode(
                $this->pass,
                PASSWORD_BCRYPT
            ),
            'encode with defrent algorism'
        );

        $this->assertIsString(
            Password::encode(
                $this->pass,
                Password::DEFAULT_ALGO,
                5320
            ),
            'encode with incresed memory cost'
        );

        $this->assertIsString(
            Password::encode(
                $this->pass,
                Password::DEFAULT_ALGO,
                Password::DEFAULT_MEMORY,
                15
            ),
            'encode with incresed time cost'
        );

        return $encoded;
    }

    public function testEncodeException() : void
    {
        $this->expectExceptionMessage('password must be longer than 6 chars');
        Password::encode(5);
    }

    public function testVerify() : void
    {
        $this->assertTrue(Password::verify($this->pass, Password::encode($this->pass)));

        $this->assertFalse(
            Password::verify(
                $this->pass . ' ',
                Password::encode($this->pass)
            ),
            'test false with space charcter'
        );
    }

    /**
     * check for rehash function
     * @depends testEncode
     */
    public function testCheckReHash(string $encoded) : void
    {

        $this->assertFalse(
            Password::checkReHash(
                $encoded
            ),
            'no rehash if nothing changed'
        );

        $this->assertTrue(
            Password::checkReHash(
                $encoded,
                PASSWORD_BCRYPT
            ),
            'rehash if algorism changed'
        );

        $this->assertTrue(
            Password::checkReHash(
                $encoded,
                Password::DEFAULT_ALGO,
                Password::DEFAULT_MEMORY + 1520
            ),
            'rehash if memory cost changed'
        );

        $this->assertTrue(
            Password::checkReHash(
                $encoded,
                Password::DEFAULT_ALGO,
                Password::DEFAULT_MEMORY,
                Password::DEFUALT_TIME + 5
            ),
            'rehash if time cost changed'
        );
    }

    public function testRandStr() : void
    {
        $this->assertIsString(
            Password::randStr()
        );

        $this->assertRegExp(
            "/[a-zA-Z0-9]+/",
            Password::randStr()
        );

        $this->assertEquals(
            48,
            strlen(Password::randStr()),
            'default length'
        );

        $this->assertEquals(
            50,
            strlen(Password::randStr(50)),
            'increse length'
        );

        $this->assertLessThanOrEqual(
            59,
            strlen(Password::randStr(75)),
            'maximum length is 59'
        );
    }

    /**
     * test hashMac method with defrenet args
     *
     * @return string
     */
    public function testHashMac() : array
    {
        $key = 'some /Thing';
        $hashed = Password::hashMac($this->pass, $key);
        $this->assertIsString(
            $hashed,
            'return string hashed'
        );

        $this->assertIsNotInt(
            $hashed
        );

        $this->assertIsString(
            Password::hashMac(
                $this->pass,
                $key,
                'sha512'
            ),
            'change sha to 512'
        );

        return [$hashed, $key];
    }

    /**
     * @depends testHashMac
     */
    public function testHashVerify(array $args) : void
    {
        [$hashed, $key] = $args;

        $this->assertTrue(
            Password::hashVerify(
                $hashed,
                Password::hashMac($this->pass, $key)
            )
        );

        $this->assertFalse(
            Password::hashVerify(
                $hashed . ' ',
                Password::hashMac($this->pass, $key)
            )
        );

        $this->assertFalse(
            Password::hashVerify(
                $hashed,
                Password::hashMac($this->pass, $key, 'sha512')
            ),
            'not equal if algorism changed'
        );
    }

    public function testProperCost() : void
    {
        $ProperTimeCost = Password::getAppropriateCost();
        fwrite(STDERR, "\t\t".'timeCost => '. $ProperTimeCost);
        
        // make sure password will be generated in this cost
        $this->assertIsString(
            Password::encode(
                $this->pass,
                Password::DEFAULT_ALGO,
                Password::DEFAULT_MEMORY,
                $ProperTimeCost
            )
        );
    }
}