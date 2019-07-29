<?php declare (strict_types=1);

namespace App;

use Whoops;
use Symfony\Component\HttpFoundation\{
    Request,
    Response
};

require_once dirname(__DIR__) . '/vendor/autoload.php';

define('IS_DEBUG', true);

// register the error handler
$whoops = new Whoops\Run;
if (IS_DEBUG) {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    $whoops->pushHandler(new Whoops\Handler\PrettyPageHandler);
} else {
    $whoops->pushHandler(function ($e) {
        echo 'TODO: Friendly error page and send email to admin';
    });
}
$whoops->register();

// require the dependecy container
$container = require_once './AppDi.php';

// create new request with the global GET, POST, FILES, SERVER, COOKIE
$requset = (new Request())::createFromGlobals();
// create new response
$response = new Response();




