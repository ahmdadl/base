<?php declare(strict_types = 1);

namespace App\Middlewares;

use Symfony\Component\HttpFoundation\Request;

class CsrfVerify extends Base
{
    public function process()
    {
        $token = parent::$request->request->get('csrfToken');
        var_dump($token);
        if (hash_equals('asdasd', $token)) {
            return true;
        }
    }
}