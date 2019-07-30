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
