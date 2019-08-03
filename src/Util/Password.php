<?php declare (strict_types=1);

namespace app\Util;

class Password
{
    // default algorthim to be used
    const DEFAULT_ALGO = PASSWORD_ARGON2ID;
    // 8-10 is a good base line
    const DEFAULT_COST = 10;
    
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
