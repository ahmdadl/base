<?php declare (strict_types=1);

namespace App;

use Whoops;
use App\Route\Router;

require_once dirname(__DIR__) . '/vendor/autoload.php';

define('IS_DEBUG', true);
define('ROOT_DIR', dirname(__DIR__) . DIRECTORY_SEPARATOR);
// register the error handler
$whoops = new Whoops\Run;
if (IS_DEBUG) {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    $whoops->pushHandler(new Whoops\Handler\PrettyPageHandler);
} else {
    $whoops->pushHandler(function ($e) {
        // var_dump($e);
        echo 'TODO: Friendly error page and send email to admin';
    });
}
$whoops->register();

// require the dependecy container
$container = require_once __DIR__ . '/AppDi.php';

// get request from di container and create new request with
// the global GET, POST, FILES, SERVER, COOKIE
$requset = $container->get ('Symfony\Component\HttpFoundation\Request');
// create new response
$response = $container->get('Symfony\Component\HttpFoundation\Response');

// require web routes
$routes = require_once dirname(__DIR__) . '/routes/web.php';
// init router
$router = new Router(
    $requset,
    $response,
    $container,
    IS_DEBUG
);
// set routes
$router->setRoutes($routes);

// check for custom errors
// try {
    $router->run();

    // fix http headers
    $response->prepare($requset);
    // show response
    $response->send();
// } catch(\Exception $e) {
//     echo 'asdasd' . $e->getMessage();
// }





