<?php

declare(strict_types=1);

use FastRoute\RouteCollector;

return function (RouteCollector $r) {
    // home routes
    $r->get('/', ['HomeController@show']);
    $r->get('/fonts/{font}', ['AssetController@fonts']);
    $r->get('/posts/img/{img}', ['AssetController@postImg']);

    // error
    $r->get('/errors/{num}', ['AssetController@handelErrors']);


    // blog routes
    $r->addGroup('/blog', function (RouteCollector $r) {
        $r->get('', ['HomeController@toPosts']);
        $r->addGroup('/posts', function (RouteCollector $r) {
            $r->get('', ['PostController@index']);
            $r->post('', [
                'PostController@save',
                'middlewares' => ['AdminAuth', 'CsrfVerify']
            ]);
            $r->delete('/{pid}', [
                'PostController@destroy',
                'middlewares' => ['AdminAuth', 'CsrfVerify']
            ]);
            $r->get('/create', ['PostController@create']);
            $r->get('/s', ['PostController@find']);
            $r->get('/{slug}', ['PostController@show']);
            $r->get('/{slug}/edit', ['PostController@edit']);
            $r->post('/{slug}', [
                'PostController@update',
                'middlewares' => ['AdminAuth', 'CsrfVerify']
            ]);
        });

        $r->addGroup('/cat', function (RouteCollector $r) {
            $r->post('', [
                'CategoryController@store',
                'middlewares' => ['AdminAuth', 'CsrfVerify']
            ]);
            $r->get('/{id}/{title}', ['CategoryController@index']);
            $r->get('/create', ['CategoryController@create']);
        });
    });

    // admin routes
    $r->addGroup('/root', function (RouteCollector $r) {
        $r->post('', [
            'AdminController@letMeIn',
            'middlewares' => ['AdminAuth', 'CsrfVerify']
        ]);
        $r->get('/login', ['AdminController@login']);
        $r->post('/logout', [
            'AdminController@logOut',
            'middlewares' => ['AdminAuth', 'CsrfVerify']
        ]);
    });

    // api routes
    $r->addGroup('/api', function (RouteCollector $r) {
        $r->post('/sendMail', [
            'HomeController@saveMail',
            'middlewares' => ['AdminAuth', 'CsrfVerify']
        ]);

        $r->post('/sendComment', [
            'CommentController@store',
            'middlewares' => ['AdminAuth', 'CsrfVerify']
        ]);
        $r->post('/allComments', [
            'CommentController@index',
            'middlewares' => ['AdminAuth', 'CsrfVerify']
        ]);
        $r->delete('/comments/{cid}', [
            'CommentController@destroy',
            'middlewares' => ['AdminAuth', 'CsrfVerify']
        ]);
    });
};
