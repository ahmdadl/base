<?php declare (strict_types=1);

use FastRoute\RouteCollector;

return function (RouteCollector $r) {
    $uri = '/ft/public';
    $r->get($uri . '/', ['App\Controllers\Home::show',
    'middlewares' => ['Auth',]]);
    $r->addRoute(['GET', 'POST'], $uri . '/addNew', ['App\Controllers\Joke::addNew']);
    $r->addRoute(['GET', 'POST'], $uri . '/edit/j/{id}', [
        'App\Controllers\Joke::edit'
    ]);
    $r->addRoute(['POST', 'DELETE'], $uri. '/delete/j/{id}', [
        'App\Controllers\Joke::delete',
    ]);
    $r->get($uri . '/logIn', ['App\Controllers\User::logIn']);
    $r->post($uri . '/logIn', [
        'App\Controllers\User::logIn',
        'middlewares' => ['CsrfVerify']
    ]);
};

