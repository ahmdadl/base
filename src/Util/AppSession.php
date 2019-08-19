<?php declare (strict_types=1);

namespace App\Util;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Util\Password;
use Symfony\Component\HttpFoundation\Request;

class AppSession
{
    const CHECK_IP_ADDRESS = false; // check if user changed ip
    const CHECK_BROWSER = true; // check if user changed browser
    // const SAME_SITE = 'Strict'; // or lax for more than one domain
    const SESSION_MAXLIFE = 1800; // 1800 sec ==> 30 min
    // const Strict_MODE = 1; // or 0

    /**
     * Request Instance
     *
     * @var Request
     */
    private $request;
    /**
     * session max life period to change session id after it
     *
     * @var int
     */
    private $maxlife;
    /**
     * Session Instance
     *
     * @var Session
     */
    public $se;

    public function __construct(
        SessionInterface $session,
        Request $request,
        int $maxlife
        ) {
        $this->se = $session;
        $this->request = $request;
        $this->maxlife = $maxlife;
    }

    /**
     * start the session
     * and prevent Browser OR Ipaddress
     * and set the two csrf Tokens
     *
     * @param boolean $preventIP
     * @param boolean $preventBrowser
     * @return void
     */
    public function sessStart(
        bool $preventIP = self::CHECK_IP_ADDRESS,
        bool $preventBrowser = self::CHECK_BROWSER,
        int $maxlife = self::SESSION_MAXLIFE
    ) : void
    {
        $this->se->start();

        // check prevent multible ip and browser
        // session is created
        if (($preventBrowser || $preventIP)
        && !$this->preventMultiIP($preventIP, $preventBrowser)) {
            // fwrite(STDOUT, "\nprevnet browser\n");
            // destory session
            $this->se->invalidate();

            if ($preventIP) $this->setUserIP();
            if ($preventBrowser) $this->setUserAgent();
        }

        // set the csrf token
        $this->setCsrfToken();

        // check session active time
        $this->checkActivity($maxlife);
    }

    /**
     * add new session key
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set(string $key, $value) : void
    {
        $this->se->set($key, $value);
    }

    /**
     * get value from session by name
     *
     * @param string $key
     * @return void
     */
    public function get(string $key)
    {
        return $this->se->get($key);
    }
    
    /**
     * check if key exists in session array
     *
     * @param string $key
     * @return boolean
     */
    public function has(string $key) : bool
    {
        return $this->se->has($key);
    }

    /**
     * add flash session that will be used one time then deleted
     *
     * @param string $type
     * @param string $value
     * @return void
     */
    public function addFlash(string $type, string $value) : void
    {
        $this->se->getFlashBag()->add($type, $value);
    }

    /**
     * retrive all flash session messages by it`s type
     *
     * @param string $type
     * @return void
     */
    public function getFlash(string $type) : array {
        return $this->se->getFlashBag()->get($type);
    }

    /**
     * retrive all stored flash sessions
     *
     * @return array [type => [messages]]
     */
    public function getAllFlash() : array
    {
        return $this->se->getFlashBag()->all();
    } 

    /**
     * set the csrf token to random string
     *
     * @return void
     */
    private function setCsrfToken() : void
    {
        // check for general purpose token
        if (!$this->se->has('X_CSRF_TOKEN')) {
            // default length is 48
            $this->se->set('X_CSRF_TOKEN', Password::randStr());
        }

        // add an per-form csrf token
        if (!$this->se->has('Form_Token')) {
            $this->se->set('Form_Token', Password::randStr());
        }
    }

    private function setUserIP() : void
    {
        $this->se->set('userIP', $this->encode('REMOTE_ADDR'));
    }

    private function getUserIP() : ?string
    {
        return $this->se->get('userIP');
    }

    private function setUserAgent() : void
    {
        $this->se->set('userAgent', $this->encode('HTTP_USER_AGENT'));
    }

    private function getUserAgent() : ?string
    {
        return $this->se->get('userAgent');
    }

    /**
     * hash server attributes to check if session hijaked
     *
     * @param string $server_attr
     * @return string
     */
    private function encode(string $server_attr) : string
    {
        return Password::hashMac(
            $this->request->server->get($server_attr),
            '41c6dee3uX0E2hwmpVKuqbyIkbs43GN9QLW41u3y'
        );
    }

    private function checkActivity(int $maxlife = null)
    {
        $maxlife = $maxlife ?? $this->maxlife;
        if (time() - $this->se->getMetadataBag()->getLastUsed() > $maxlife) {
            // clear all session and regenerate id
            $this->se->invalidate();
            // redirect to logOut page
            // (new RedirectResponse('logOut'))->send();
        } else if(time() - $this->se->getMetadataBag()->getCreated() > $maxlife) {
            // just regenrate session id
            // @codeCoverageIgnoreStart
            $this->se->migrate();
            // @codeCoverageIgnoreEnd
        }
    }

    private function preventMultiIP(
        bool $preventIP,
        bool $preventBrowser
    ) : bool
    {
        if ($preventIP && !$this->se->has('userIP')) {
            $this->setUserIP();
        }
        if ($preventBrowser && !$this->se->has('userAgent')) {
            $this->setUserAgent();
        }

        // check for ip address
        if ($preventIP
        && (!Password::hashVerify($this->getUserIP(), $this->encode('REMOTE_ADDR')))) {
            return false;
        }

        // check for user browser
        if ($preventBrowser
        && (!Password::hashVerify($this->getUserAgent(), $this->encode('HTTP_USER_AGENT'))) ) {
            return false;
        }

        return true;
    }
    
}