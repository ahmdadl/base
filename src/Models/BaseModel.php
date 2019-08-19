<?php declare(strict_types = 1);

namespace App\Models;

abstract class BaseModel
{
    public function __set(string $key, $value) : void
    {
        $this->key = htmlspecialchars($value, ENT_QUOTES);
    }
}