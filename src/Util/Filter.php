<?php

declare(strict_types=1);

namespace App\Util;

final class Filter
{
    /**
     * filter string to prevent xss attacks
     *
     * @param string $str
     * @return string
     */
    public static function filterStr($str): ?string
    {
        if (!isset($str) || empty(trim($str))) return null;

        $str = trim($str);
        $str = filter_var($str, FILTER_SANITIZE_STRING);
        $str = htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
        $str = strip_tags($str);
        $str = stripslashes($str);

        return $str;
    }

    public static function len($str, int $min, int $max = null) : bool
    {
        if (null !== $max) {
            return (strlen($str) >= $min) && (strlen($str) <= $max);
        }

        return strlen($str) >= $min;
    }
}
