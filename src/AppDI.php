<?php declare (strict_types=1);

namespace App;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use App\Util\AppSession;

/**
 * @var ROOT_DIR is placed at /src/Bootstrap.php
 */
// define directory constants
define('View_DIR', ROOT_DIR .'resources'. DIRECTORY_SEPARATOR .'views'. DIRECTORY_SEPARATOR);
define('CONFIG_DIR', ROOT_DIR .'config'. DIRECTORY_SEPARATOR);
define('PAGE_DIR', ROOT_DIR .'pages'. DIRECTORY_SEPARATOR);

$cachedFile = ROOT_DIR . 'cache/containerBulider.php';

/**
 * @var IS_DEBUG is placed at /src/Bootstrap.php
 * so no need to redefine it as this file
 * as it will be included there
 */
$cacheContainerConfig = new ConfigCache($cachedFile, IS_DEBUG);

// check if cached file content changed
if (!$cacheContainerConfig->isFresh()) {
    // rebuild the container
    $container = new ContainerBuilder();

    // set contaianer params
    // pageReader params
    $container->setParameter('pagesDir', PAGE_DIR);
    // template render params
    $container->setParameter('viewsDir', View_DIR);
    // hashids salt
    $container->setParameter('salt', '4e46c93890f89ff4dd3e41513c377ba11fa495a42d26ab1342c49086ae7c630fc91e0d');
    // hashids min length
    $container->setParameter('minLength', 5);
    // session options
    $container->setParameter('session_options', [
        'name' => strtoupper($_SERVER['HTTP_HOST']) . 'SESSION',
        'use_strict_mode' => AppSession::Strict_MODE,
        // un comment if cookie not needed for javascript access
        // 'cookie_httponly' => 1,
        // 'gc_maxlifetime' => AppSession::SESSION_MAXLIFE,
        'gc_probability' => 0,
        'cookie_lifetime' => AppSession::SESSION_MAXLIFE + 10,
        // 'gc_divisor' => AppSession::SESSION_GC_DIVISOR,
        'cookie_samesite' => AppSession::SAME_SITE,
        'sid_length' => 48,
        'sid_bits_per_character' => 6,
        // frame and area is not used
        // 'trans_sid_tags' => 'a=href,form=',
    ]);

    // locate config direcory
    $fileLocator = new FileLocator(CONFIG_DIR);
    $loader = new YamlFileLoader($container, $fileLocator);
    // load servies file
    $loader->load('services.yml');
    // compile the container
    $container->compile();

    // cache the containe
    $dumper = new PhpDumper($container);
    // set cached container className as .. new ClassName(); 
    $cacheContainerConfig->write(
        $dumper->dump(['class' => 'AppDiContainer']),
        $container->getResources()
    );
} else {
    // if not require the cached file
    require_once $cachedFile;

    // init container
    $container = new \AppDiContainer();
}

// return the container
return $container;
