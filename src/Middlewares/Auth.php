<?php declare(strict_types = 1);

namespace App\Middlewares;

class Auth extends Base implements MiddlewareInterface
{
    /**
     * all documention at Base Class
     *
     * @return bool
     */
    public function process() : bool
    {
        // get saved in session csrf token
        $known = $this->session->se->get('X_CSRF_TOKEN');
        // get the token submited with user input
        $token = $this->request->request->get('csrfToken');
        // check if the two tokens not equal
        if (hash_equals($known, $token)) {
            // if no error
            return false;
        }

        // send message to view via flash sessions
        $this->session->se->getFlashBag()->add(
            'danger',
            'an error occured. please try again later'
        );
        // stop any other middleware
        return true;
    }
}