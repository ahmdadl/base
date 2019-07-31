<?php declare (strict_types=1);

namespace App\Util;

use Symfony\Component\HttpFoundation\Session\{
    Session,
    Storage\NativeSessionStorage
};

class AppSession
{
    const CHECK_IP_ADDRESS = true; // check if user changed ip
    const CHECK_BROWSER = true; // check if user changed browser
    const SAME_SITE = 'Strict'; // or lax for more than one domain
    const SESSION_MAXLIFE = 1800; // 1800 sec ==> 30 min

    private static $session;

    public function __construct() {}
    
    private static function start()
    {
        self::$session = new Session(new NativeSessionStorage([
            'name' => strtoupper($_SERVER['HTTP_HOST']) . 'SESSION',
            'use_strict_mode' => 1,
            // un comment if cookie not needed for javascript access
            // 'cookie_httponly' => 1,
            'gc_maxlifetime' => self::SESSION_MAXLIFE,
            'cookie_samesite' => self::SAME_SITE,
            'sid_length' => 48,
            'sid_bits_per_character' => '6',
            // frame and area is not used
            // 'trans_sid_tags' => 'a=href,form=',
        ]));

        // start the session
        self::$session->start();
    }

    public static function getInstance()
    {
        if (self::$session === null) self::start();
        return self::$session;
    }

    /**
     * destroy old session and create one with new session ID
     *
     * @return void
     */
    public function reGenID() : void
    {
        // useful for multible requests at the same time
        // and stopping unstable newtwork connection
        $this->obsolete = time();
        $this->newSessionID = true;

        // destroy old sessions
        $this->close();

        // regenrate session ID
        $this->reGenerateSessID();

        // remove for new session
        $this->__unset('obsolete');
        $this->__unset('newSessionID');
    }
    
}