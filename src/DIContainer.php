<?php declare (strict_types=1);

namespace App;

use Symfony\Component\DependencyInjection\{
    ContainerBuilder,
    Dumper\PhpDumper,
    Loader\YamlFileLoader
};
use Symfony\Component\Config\{
    ConfigCache,
    FileLocator
};

/**
 * build the dependency injection container and cache it
 * or just require the cheched version if no changes has happend
 * 
 * usage => ( new DIContainer() )->getContainer(configArray)
 */
class DIContainer
{
    /**
     * the cached container file name
     */
    const CACHED_FILE = 'containerBulider.php';

    /**
     * app configrations
     *
     * @var array
     */
    private $config;
    /**
     * ConfigCache instance to handle changes in file
     *
     * @var ConfigCache
     */
    private $cacheContainerConfig;
    /**
     * the di container itself
     *
     * @var DIContainer
     */
    private $container;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * get the container instance
     *
     * @return ContainerBuilder
     */
    public function getContainer()
    {
        // iniate the container
        $this->setCacheContainerConfig();

        // check if cache file has changed or file not exists
        if (!$this->cacheContainerConfig->isFresh()
        || !file_exists($this->config['dir']['cache'] . self::CACHED_FILE)) {
            // rebuild container
            $this->build();
        } else {
            $this->loadCachedContainer();
        }

        return $this->container;
    }

    /**
     * create new instane of container Builder 
     * and rebuild the container then cache it
     *
     * @return void
     */
    private function build() : void
    {
        $this->container = new ContainerBuilder();

        $this->setParams();

        $this->loadServices();

        $this->cacheContainer();
    }

    private function loadCachedContainer() : void
    {
        require_once $this->config['dir']['cache'] . self::CACHED_FILE;
        $this->container = new \AppDIContainer();
    }

    /**
     * iniate the configCache
     *
     * @return void
     */
    private function setCacheContainerConfig() : void
    {
        $this->cacheContainerConfig = new ConfigCache(
            $this->config['dir']['cache'] . self::CACHED_FILE,
            $this->config['isDebug']
        );
    }

    /**
     * set Container parameters
     *
     * @return void
     */
    private function setParams() : void
    {
        // template render params
        $this->container->setParameter(
            'viewsDir',
            $this->config['dir']['views']
        );
        // hashids salt
        $this->container->setParameter(
            'salt',
            $this->config['hashids'] ['salt']
        );
        // hashids min length
        $this->container->setParameter(
            'minLength',
            $this->config['hashids']['minLength']
        );
        
        // session options
        $this->container->setParameter(
            'session.maxlife',
            $this->config['session']['maxlife']
        );
        $this->container->setParameter('session_options', [
            'name' => $this->config['session']['name'] ?? $this->config['name'] . 'SessID',
            'use_strict_mode' => true,
            // disable and handle regenrate session ID manauly
            'gc_probability' => 0,
            'cookie_lifetime' => $this->config['session']['maxlife'] + 10,
            'cookie_samesite' => $this->config['session']['samesite'],
            'sid_length' => 48,
            'sid_bits_per_character' => 6,
        ]);
    }

    /**
     * load servies from services.yml file
     *
     * @return void
     */
    private function loadServices() : void
    {
        // locate config direcory
        $fileLocator = new FileLocator(
            $this->config['dir']['config']
        );
        $loader = new YamlFileLoader($this->container, $fileLocator);
        // load servies file
        $loader->load('services.yml');
        // compile the container
        $this->container->compile();
    }

    /**
     * cache the container with className as AppDIContainer
     *
     * @return void
     */
    private function cacheContainer() : void
    {
        // cache the containe
        $dumper = new PhpDumper($this->container);
        // set cached container className as .. new ClassName(); 
        $this->cacheContainerConfig->write(
            $dumper->dump(['class' => 'AppDIContainer']),
            $this->container->getResources()
        );
    }
}