<?php declare (strict_types=1);

namespace App;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Twig_Loader_Filesystem;
use Twig\{
    Loader\FilesystemLoader,
    Environment
};

// define directory constants
define('ROOT_DIR', dirname(__DIR__));
define('View_DIR', ROOT_DIR . '/resources/views/');
define('CONFIG_DIR', ROOT_DIR . '/config//');
define('PAGE_DIR', ROOT_DIR . '/pages//');

$cachedFile = ROOT_DIR . 'cache/containerBulider.php';
/**
 * @var IS_DEBUG is placed at /src/Bootstrap.php
 * so no need to redefine it as this file will be
 * included there
 */

$cacheContainerConfig = new ConfigCache($cachedFile, IS_DEBUG);

// check if cached file content changed
if (!$cacheContainerConfig->isFresh()) {
    // rebuild the container
    $container = new ContainerBuilder();

    // set contaianer params
    // pageReader params
    $container->setParameter('pagesDir', PAGE_DIR);
    // twig params
    $container->setParameter('views', View_DIR);

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
        $dumper->dump(['class' => 'MainDiContainer']),
        $container->getResources()
    );
} else {
    // if not require the cached file
    require_once $cacheFile;

    // init container
    $container = new \MainDiContainer();
}

// return the container
return $container;
