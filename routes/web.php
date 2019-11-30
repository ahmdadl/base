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
            $r->delete('/{pid}', ['PostController@destroy']);
            $r->get('/create', ['PostController@create']);
            $r->get('/s', ['PostController@find']);
            $r->get('/{slug}', ['PostController@show']);
            $r->get('/{slug}/edit', ['PostController@edit']);
            $r->post('/{slug}', [
                'PostController@update',
                'middlewares' => ['CsrfVerify']
            ]);
        });

        $r->addGroup('/cat', function (RouteCollector $r) {
            $r->get('/{id}/{title}', ['CategoryController@index']);
            $r->get('/create', ['CategoryController@create']);
        });
    });

    // admin routes
    $r->addGroup('/root', function (RouteCollector $r) {
        $r->post('', [
            'AdminController@letMeIn',
            'middlewares' => ['CsrfVerify']
        ]);
        $r->get('/login', ['AdminController@login']);
        $r->post('/logout',[
            'AdminController@logOut',
            'middlewares' => ['CsrfVerify']
        ]);
    });

    // api routes
    $r->addGroup('/api', function (RouteCollector $r) {
        $r->post('/sendMail', [
            'HomeController@saveMail',
            'middlewares' => ['CsrfVerify']
        ]);

        $r->post('/sendComment', [
            'CommentController@store',
            'middlewares' => ['CsrfVerify']
        ]);
        $r->post('/allComments', [
            'CommentController@index',
            'middlewares' => ['CsrfVerify']
        ]);
    });
};
