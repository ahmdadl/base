<?php declare (strict_types=1);

use FastRoute\RouteCollector;

return function (RouteCollector $r) {
    $uri = '/ft/public';
    $r->get($uri . '/', ['App\Controllers\Home::show']);
    $r->get($uri . '/addNew', ['App\Controllers\Joke::addNew']);
};

