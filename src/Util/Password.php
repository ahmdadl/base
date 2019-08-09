<?php declare (strict_types=1);

namespace app\Util;

class Password
{
    // default algorthim to be used
    const DEFAULT_ALGO = PASSWORD_ARGON2ID;
    /**
    * * consider increasing it depending on your hardware 
    */
    // default memory cost in bytes ==> 1024
    const DEFAULT_MEMORY = PASSWORD_ARGON2_DEFAULT_MEMORY_COST;
    // default time cost
    const DEFUALT_TIME = 5;
    // random string length
    const RAND_LENGTH = 48;
    
    public function __construct() {}

    /**
     * encode password with provided params
     *
     * @param mixed|string $pass
     * @return string
     */
    public static function encode(
        $pass,
        int $algo = self::DEFAULT_ALGO,
        int $memory = self::DEFAULT_MEMORY,
        int $time = self::DEFUALT_TIME
    ) : string {
        if (strlen((string)$pass) < 6) {
            throw new \Exception('password must be longer than 6 chars');
            // throw new InvalidArgumentException('password must be longer than 5 chars')
        }
        return password_hash($pass, $algo, [
            'memory_cost' => $memory,
            'time_cost' => $time
        ]);
    }

    /**
     * verify password
     *
     * @param mixed|string $userPass
     * @param string $hash
     * @return boolean
     */
    public static function verify($userPass, string $hash) : bool
    {
        return password_verify($userPass, $hash);
    }

    public static function checkReHash(
        string $hash,
        int $algo = self::DEFAULT_ALGO,
        int $memory = self::DEFAULT_MEMORY,
        int $time = self::DEFUALT_TIME
    ) : bool {
        return password_needs_rehash($hash, $algo, [
            'memory_cost' => $memory,
            'time_cost' => $time
        ]);
    }

    /**
     * create random string with 256hash method
     * Maximum Length Returned Is 59
     * @param integer $length
     * @return string
     */
    public static function randStr(
        int $length = self::RAND_LENGTH
    ) : string {
        return substr(
            crypt(base64_encode(bin2hex(random_bytes($length))), '$5$rounds=5000$'.bin2hex(random_bytes($length)).'$'),
            16, $length);
    }

    /**
     * create two way crypto function for usage with per-form token
     *
     * @param string $string
     * @param string $key
     * @param string $algo
     * @return string
     */
    public static function hashMac(
        string $string,
        string $key,
        $algo = 'sha256'
    ) : string {
        return hash_hmac($algo, $string, $key);
    }

    /**
     * decrypt the hashed value and 
     * check if it equals the user entered value
     *
     * @param string $known
     * @param string $userInp
     * @return boolean
     */
    public static function hashVerify(string $known, string $userInp) : bool
    {
        return hash_equals($known, $userInp);
    }

    /**
     * test website to caculate the best time cost
     * the function can run in less than 50 milliseconds
     * 
     * @see https://www.php.net/manual/en/function.password-hash.php
     * @return integer
     */
    public static function getAppropriateCost() : int
    {
        // it must be under 100 milliseconds
        $timeTarget = 0.05; // 50 milliseconds 

        $timeCost = 2;
        do {
            $timeCost++;
            $start = microtime(true);
            password_hash("test", self::DEFAULT_ALGO, [
                "time_cost" => $timeCost
            ]);
            $end = microtime(true);
        } while (($end - $start) < $timeTarget);

        return $timeCost;
    }
}
