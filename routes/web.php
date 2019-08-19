<?php declare (strict_types=1);

use FastRoute\RouteCollector;

return function (RouteCollector $r) {
    $uri = '/fc/public';
    $r->get($uri . '/', ['Home@show',
    'middlewares' => []]);
    $r->get($uri . '/logIn', ['Auth@logIn']);
};

