<?php declare (strict_types=1);

namespace App\View;

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
        ?string $key = null,
        ?object $session = null
    ) : string {
        // doing this to allow using static session at tester
        
        $session = $session ?? $this->session;

        if (null !== $key) {
            $token = Password::hashMac(
                $key, // string to be hashed
                $session->se->get('Form_Token') ?? '' // key
            );
        } else {
            $token = $session->se->get('X_CSRF_TOKEN') ?? '';
        }
        
        return (strlen($token) > 25) ? '<input type="hidden" name="csrfToken" value="' .
        $token . '" />' : '';
    }

    public function spaceless($html) : string
    {
        $search = [
            '/>\s+</',
            '/(\s)+/s',
            '/<!--(.|\s)*?-->/'
        ];
        $replace = [
            '><',
            '\\1',
            ''
        ];
        return trim(preg_replace($search, $replace, $html));
    }
}