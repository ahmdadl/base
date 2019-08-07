<?php declare (strict_types=1);

use FastRoute\RouteCollector;

return function (RouteCollector $r) {
    $uri = '/ft/public';
    $r->get($uri . '/', ['Home@show',
    'middlewares' => ['Auth',]]);
    $r->addRoute(['GET', 'POST'], $uri . '/addNew', ['Joke@addNew']);
    $r->addRoute(['GET', 'POST'], $uri . '/edit/j/{id}', [
        'Joke@edit'
    ]);
    $r->addRoute(['POST', 'DELETE'], $uri. '/delete/j/{id}', [
        'Joke@delete',
    ]);
    $r->get($uri . '/logIn', ['User@logIn']);
    $r->post($uri . '/logIn', [
        'User@logIn',
        'middlewares' => ['CsrfVerify']
    ]);
};

