<?php

declare(strict_types=1);

use FastRoute\RouteCollector;

return function (RouteCollector $r) {
    // home routes
    $r->get('/', ['HomeController@show']);
    $r->get('/fonts/{font}', ['AssetController@fonts']);
    $r->get('/posts/img/{img}', ['AssetController@postImg']);

    
    // blog routes
    $r->addGroup('/blog', function (RouteCollector $r) {
        $r->get('', ['HomeController@toPosts']);
        $r->addGroup('/posts', function (RouteCollector $r) {
            $r->get('', ['PostController@index']);
            $r->post('', ['PostController@save']);
            $r->get('/create', ['PostController@create']);
            $r->get('/s', ['PostController@find']);
            $r->get('/{slug}', ['PostController@show']);
        });

        $r->addGroup('/cat', function (RouteCollector $r) {
            $r->get('/{id}/{title}', ['CategoryController@index']);
        });
    });

    // api routes
    $r->post('/api/sendMail', [
        'HomeController@saveMail',
        'middlewares' => ['CsrfVerify']
    ]);
    $r->post('/api/sendComment', [
        'CommentController@store',
        'middlewares' => ['CsrfVerify']
    ]);
};
