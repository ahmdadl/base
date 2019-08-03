<?php declare(strict_types = 1);

namespace App\Middlewares;

use Symfony\Component\HttpFoundation\Request;

class CsrfVerify extends Base implements MiddlewareInterface
{
    /**
     * all documention at Base Class
     *
     * @return bool
     */
    public function process() : bool
    {
        // get saved in session csrf token
        $known = parent::$session->se->get('X_CSRF_TOKEN');
        // get the token submited with user input
        $token = parent::$request->request->get('csrfToken');
        // check if the two tokens not equal
        if (!hash_equals($known, $token)) {
            // send message to view via flash sessions
            parent::$session->se->getFlashBag()->add(
                'danger',
                'an error occured. please try again later'
            );

            // stop any other middleware
            return true;
        }

        // if no error
        return false;
    }
}