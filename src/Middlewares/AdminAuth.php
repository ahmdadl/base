<?php

declare(strict_types=1);

namespace App\Middlewares;

class AdminAuth extends Base implements MiddlewareInterface
{
    /**
     * all documention at Base Class
     *
     * @return bool
     */
    public function process(): bool
    {
        // check if admin has logged in
        if ($this->session->se->has('admin') &&
            $this->session->se->has('userName')) {
                return false;
            }

        // stop any other middleware
        return true;
    }
}
