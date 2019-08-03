# MVC is very good
## I wish i can use it for ever
### Example
```php
<?php declare(strict_types = 1);

namespace App\Util;

class Filter
{
    private $name;

    public function _construct(StdClass $name)
    {
        $this->name = $name;
    }

    public function __set($key, $value) : void
    {
        $this->$key = strtoupper($value);
    }
}
```