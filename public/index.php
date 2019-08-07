<?php declare (strict_types=1);

use App\Bootstrap;

// auto injoked function to keep the outer namespace clean
(function() {
    require_once dirname(__DIR__) . '/vendor/autoload.php';

    // load app configrations
    $config = require_once dirname(__DIR__) . '/config/app.php';
    // load web routes
    $routes = require_once dirname(__DIR__) . '/routes/web.php';

    // run the app
    (new Bootstrap($config, $routes))->run();
})();