<?php declare (strict_types=1);

namespace app\Util;

class Password
{
    // default algorthim to be used
    const DEFAULT_ALGO = PASSWORD_ARGON2ID;
    // 8-10 is a good base line
    const DEFAULT_COST = 10;
    // random string length
    const RAND_LENGTH = 48;
    
    public function __construct() {}

    /**
     * encode password with provided params
     *
     * @param mixed|string $pass
     * @return string
     */
    public static function encode($pass) : string
    {
        return password_hash($pass, self::DEFAULT_ALGO, [
            'cost' => self::DEFAULT_COST,
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

    public static function checkReHash(string $hash) : bool
    {
        return password_needs_rehash($hash, self::DEFAULT_ALGO, [
            'cost' => self::DEFAULT_COST,
        ]);
    }

    public static function randStr(int $length = self::RAND_LENGTH) : string
    {
        return substr(
            crypt(base64_encode(bin2hex(random_bytes(48))), '$5$rounds=5000$'.bin2hex(random_bytes(48)).'$'),
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
     * test website to caculate the best cost
     * 
     * @see https://www.php.net/manual/en/function.password-hash.php
     * @return integer
     */
    public static function getAppropriateCost() : int
    {
        // it must be under 100 milliseconds
        $timeTarget = 0.08; // 80 milliseconds 

        $cost = 8;
        do {
            $cost++;
            $start = microtime(true);
            password_hash("test", self::DEFAULT_ALGO, ["cost" => $cost]);
            $end = microtime(true);
        } while (($end - $start) < $timeTarget);

        return $cost;
    }
}
