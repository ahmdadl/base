<?php declare (strict_types=1);

namespace AppTest\View;

use App\Util\Password;

trait FrontRenderTrait
{
    /**
     * escape string
     *
     * @param mixed|string $str
     * @return mixed|string
     */
    public function es($str)
    {
        return trim(htmlspecialchars(strip_tags((string)$str), ENT_QUOTES));
    }

    public function _method(string $method = 'post') : string
    {
        return '<input type="hidden" name="_method" value="'.
        strtoupper($method) . '" />';
    }

    public function csrf(
        ?string $key = null
    ) : string {
        if (null !== $key) {
            $token = Password::hashMac(
                $key, // string to be hashed
                self::$session->se->get('Form_Token') ?? '' // key
            );
        } else {
            $token = self::$session->se->get('X_CSRF_TOKEN') ?? '';
        }
        
        return (strlen($token) > 25) ? '<input type="hidden" name="csrfToken" value="' .
        $token . '" />' : '';
    }
}