<?php declare (strict_types=1);

use FastRoute\RouteCollector;

return function (RouteCollector $r) {
    $uri = '/fc/public';
    $r->get($uri . '/', ['Post@getAll',
    'middlewares' => ['AuthCookie']]);
    $r->get($uri . '/logIn', ['Auth@logIn']);
    $r->post($uri . '/logIn', ['Auth@logIn',
    'middlewares' => ['CsrfVerify']]);
    $r->get($uri . '/signUp', ['Auth@signUp']);
    $r->post($uri . '/signUp', ['Auth@signUp',
    'middlewares' => ['CsrfVerify']]);
    // grourp route for post
    $r->addGroup($uri . '/p/{id:[a-zA-Z0-9]+}', function (RouteCollector $r) {
        $r->get('', ['Post@getOne']);
        $r->addRoute(
            ['PUT', 'POST', 'GET'],
            '/edit', 
            ['Post@edit']
        );
        $r->addRoute(
            ['DELETE', 'POST'],
            '/delete', 
            ['Post@deletePost']
        );
    });
};

