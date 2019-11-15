<?php

declare(strict_types=1);

use FastRoute\RouteCollector;

return function (RouteCollector $r) {
    $r->get('/', ['HomeController@show']);
    $r->get('/fonts/{font}', ['AssetController@fonts']);

    // api routes
    $r->post('/api/sendMail', [
        'HomeController@saveMail',
        'middlewares' => ['CsrfVerify']
    ]);
};
