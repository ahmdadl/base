<?php declare(strict_types = 1);

namespace App\Middlewares;

use Symfony\Component\HttpFoundation\Request;
use App\Util\AppSession;

abstract class Base
{
    protected static $request;
    protected static $session;
    public function __construct(
        Request $request,
        AppSession $session
    ) {
        self::$request = $request;
        self::$session = $session;
    }

    /**
     * process the middleware and return the response
     * 
     * ! All Middlewares will be handled at App\Route\Router
     * 
     * * any error that ocuure in an middleware class will stop 
     * * any othe one from working and will be checked at front
     * * controller to prevent any additional work and just return
     * * view with proper error message ex..an error has occured
     * * The Error Will be pathed away through flash Sessions
     * 
     * so if the first middleware stopped with error
     * no other one will be working
     * and the front controller will not handle user input and 
     * just render the default view with proper error message
     *
     * @return bool true if any error
     */
    public abstract function process() : bool;

    // /**
    //  * return the proper array
    //  *
    //  * @param boolean $hasError
    //  * @param string $errorMessage
    //  * @return array
    //  */
    // protected function returnMess(
    //     bool $hasError,
    //     string $errorMessage = ''
    // ) : bool {
    //     return [
    //         'errCode' => $hasError,
    //         'error' => $errorMessage
    //     ];
    // }
}