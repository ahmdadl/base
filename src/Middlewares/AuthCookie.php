<?php declare(strict_types = 1);

namespace App\Middlewares;

use App\Controllers\Auth;
use Symfony\Component\HttpFoundation\Cookie;
use app\Util\Password;
use App\Models\AuthorModel;
use App\DbConfig\MySqli;

class AuthCookie extends Base implements MiddlewareInterface
{
    /**
     * all documention at Base Class
     *
     * @return bool
     */
    public function process() : bool
    {
        // check if login cookie exists
        // if ($this->request->cookies->has(Auth::REMEMBER_ME_COOKIE)) {
        //     // save random token in database
        //     $hash = Auth::saveRemmberToken(
        //         (new AuthorModel(new MySqli())),
        //         36
        //     );

        //     if ($hash) {
        //         // update cookie with new one time hashed string
        //         $this->response->headers->setCookie(
        //             Auth::getRemmberCookie($hash)
        //         );
        //     }

        //     Auth::setLoggedSessions(
        //         $this->session,
        //         'Ahmed Adel',
        //         'abo3adel',
        //         36
        //     );
        // }
       return true;
    }
}