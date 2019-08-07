<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\DependencyInjection\ParameterBag\FrozenParameterBag;

/**
 * This class has been auto-generated
 * by the Symfony Dependency Injection Component.
 *
 * @final since Symfony 3.3
 */
class AppDIContainer extends Container
{
    private $parameters;
    private $targetDirs = [];

    public function __construct()
    {
        $this->parameters = $this->getDefaultParameters();

        $this->services = $this->privates = [];
        $this->methodMap = [
            'App\\Controllers\\Home' => 'getHomeService',
            'App\\Controllers\\Joke' => 'getJokeService',
            'App\\Controllers\\User' => 'getUserService',
            'App\\Middlewares\\Auth' => 'getAuthService',
            'App\\Middlewares\\CsrfVerify' => 'getCsrfVerifyService',
            'App\\Route\\ErrorView' => 'getErrorViewService',
            'Symfony\\Component\\HttpFoundation\\Request' => 'getRequestService',
            'Symfony\\Component\\HttpFoundation\\Response' => 'getResponseService',
        ];

        $this->aliases = [];
    }

    public function compile()
    {
        throw new LogicException('You cannot compile a dumped container that was already compiled.');
    }

    public function isCompiled()
    {
        return true;
    }

    public function getRemovedIds()
    {
        return [
            'App\\DbConfig\\MySqli' => true,
            'App\\Middlewares\\MiddlewareInterface' => true,
            'App\\Util\\AppSession' => true,
            'App\\View\\FrontRenderInterface' => true,
            'DB\\Model\\HomeModel' => true,
            'DB\\Model\\UserModel' => true,
            'Hashids\\Hashids' => true,
            'League\\Plates\\Engine' => true,
            'Psr\\Container\\ContainerInterface' => true,
            'Symfony\\Component\\DependencyInjection\\ContainerInterface' => true,
            'Symfony\\Component\\HttpFoundation\\RedirectResponse' => true,
            'Symfony\\Component\\HttpFoundation\\Session\\SessionInterface' => true,
            'session_attrbag' => true,
            'session_storage' => true,
        ];
    }

    /**
     * Gets the public 'App\Controllers\Home' shared autowired service.
     *
     * @return \App\Controllers\Home
     */
    protected function getHomeService()
    {
        return $this->services['App\\Controllers\\Home'] = new \App\Controllers\Home(($this->services['Symfony\\Component\\HttpFoundation\\Request'] ?? $this->getRequestService()), ($this->privates['App\\View\\FrontRenderInterface'] ?? $this->getFrontRenderInterfaceService()), ($this->privates['DB\\Model\\HomeModel'] ?? $this->getHomeModelService()), ($this->privates['Hashids\\Hashids'] ?? ($this->privates['Hashids\\Hashids'] = new \Hashids\Hashids('4e46c93890f89ff4dd3e41513c377ba11fa495a42d26ab1342c49086ae7c630fc91e0d', 5))), ($this->privates['App\\Util\\AppSession'] ?? $this->getAppSessionService()));
    }

    /**
     * Gets the public 'App\Controllers\Joke' shared autowired service.
     *
     * @return \App\Controllers\Joke
     */
    protected function getJokeService()
    {
        return $this->services['App\\Controllers\\Joke'] = new \App\Controllers\Joke(($this->services['Symfony\\Component\\HttpFoundation\\Request'] ?? $this->getRequestService()), ($this->privates['DB\\Model\\HomeModel'] ?? $this->getHomeModelService()), ($this->privates['App\\View\\FrontRenderInterface'] ?? $this->getFrontRenderInterfaceService()), ($this->privates['DB\\Model\\UserModel'] ?? $this->getUserModelService()), ($this->privates['Hashids\\Hashids'] ?? ($this->privates['Hashids\\Hashids'] = new \Hashids\Hashids('4e46c93890f89ff4dd3e41513c377ba11fa495a42d26ab1342c49086ae7c630fc91e0d', 5))));
    }

    /**
     * Gets the public 'App\Controllers\User' shared autowired service.
     *
     * @return \App\Controllers\User
     */
    protected function getUserService()
    {
        return $this->services['App\\Controllers\\User'] = new \App\Controllers\User(($this->services['Symfony\\Component\\HttpFoundation\\Request'] ?? $this->getRequestService()), ($this->privates['DB\\Model\\UserModel'] ?? $this->getUserModelService()), ($this->privates['App\\View\\FrontRenderInterface'] ?? $this->getFrontRenderInterfaceService()), ($this->privates['App\\Util\\AppSession'] ?? $this->getAppSessionService()), ($this->privates['Hashids\\Hashids'] ?? ($this->privates['Hashids\\Hashids'] = new \Hashids\Hashids('4e46c93890f89ff4dd3e41513c377ba11fa495a42d26ab1342c49086ae7c630fc91e0d', 5))));
    }

    /**
     * Gets the public 'App\Middlewares\Auth' shared autowired service.
     *
     * @return \App\Middlewares\Auth
     */
    protected function getAuthService()
    {
        return $this->services['App\\Middlewares\\Auth'] = new \App\Middlewares\Auth();
    }

    /**
     * Gets the public 'App\Middlewares\CsrfVerify' shared autowired service.
     *
     * @return \App\Middlewares\CsrfVerify
     */
    protected function getCsrfVerifyService()
    {
        return $this->services['App\\Middlewares\\CsrfVerify'] = new \App\Middlewares\CsrfVerify(($this->services['Symfony\\Component\\HttpFoundation\\Request'] ?? $this->getRequestService()), ($this->privates['App\\Util\\AppSession'] ?? $this->getAppSessionService()));
    }

    /**
     * Gets the public 'App\Route\ErrorView' shared autowired service.
     *
     * @return \App\Route\ErrorView
     */
    protected function getErrorViewService($lazyLoad = true)
    {
        return $this->services['App\\Route\\ErrorView'] = new \App\Route\ErrorView(($this->privates['App\\View\\FrontRenderInterface'] ?? $this->getFrontRenderInterfaceService()));
    }

    /**
     * Gets the public 'Symfony\Component\HttpFoundation\Request' shared autowired service.
     *
     * @return \Symfony\Component\HttpFoundation\Request
     */
    protected function getRequestService()
    {
        return $this->services['Symfony\\Component\\HttpFoundation\\Request'] = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
    }

    /**
     * Gets the public 'Symfony\Component\HttpFoundation\Response' shared autowired service.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function getResponseService()
    {
        return $this->services['Symfony\\Component\\HttpFoundation\\Response'] = new \Symfony\Component\HttpFoundation\Response();
    }

    /**
     * Gets the private 'App\DbConfig\MySqli' shared autowired service.
     *
     * @return \App\DbConfig\MySqli
     */
    protected function getMySqliService($lazyLoad = true)
    {
        return $this->privates['App\\DbConfig\\MySqli'] = new \App\DbConfig\MySqli();
    }

    /**
     * Gets the private 'App\Util\AppSession' shared autowired service.
     *
     * @return \App\Util\AppSession
     */
    protected function getAppSessionService()
    {
        return $this->privates['App\\Util\\AppSession'] = new \App\Util\AppSession(new \Symfony\Component\HttpFoundation\Session\Session(new \Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage($this->parameters['session_options']), new \Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag()), ($this->services['Symfony\\Component\\HttpFoundation\\Request'] ?? $this->getRequestService()));
    }

    /**
     * Gets the private 'App\View\FrontRenderInterface' shared autowired service.
     *
     * @return \App\View\FrontRender
     */
    protected function getFrontRenderInterfaceService($lazyLoad = true)
    {
        return $this->privates['App\\View\\FrontRenderInterface'] = new \App\View\FrontRender(($this->services['Symfony\\Component\\HttpFoundation\\Request'] ?? $this->getRequestService()), ($this->services['Symfony\\Component\\HttpFoundation\\Response'] ?? ($this->services['Symfony\\Component\\HttpFoundation\\Response'] = new \Symfony\Component\HttpFoundation\Response())), new \League\Plates\Engine('C:\\xampp\\htdocs\\ft/resources/views/'), ($this->privates['App\\Util\\AppSession'] ?? $this->getAppSessionService()));
    }

    /**
     * Gets the private 'DB\Model\HomeModel' shared autowired service.
     *
     * @return \DB\Model\HomeModel
     */
    protected function getHomeModelService()
    {
        return $this->privates['DB\\Model\\HomeModel'] = new \DB\Model\HomeModel(($this->privates['App\\DbConfig\\MySqli'] ?? $this->getMySqliService()));
    }

    /**
     * Gets the private 'DB\Model\UserModel' shared autowired service.
     *
     * @return \DB\Model\UserModel
     */
    protected function getUserModelService()
    {
        return $this->privates['DB\\Model\\UserModel'] = new \DB\Model\UserModel(($this->privates['App\\DbConfig\\MySqli'] ?? $this->getMySqliService()));
    }

    public function getParameter($name)
    {
        $name = (string) $name;

        if (!(isset($this->parameters[$name]) || isset($this->loadedDynamicParameters[$name]) || array_key_exists($name, $this->parameters))) {
            throw new InvalidArgumentException(sprintf('The parameter "%s" must be defined.', $name));
        }
        if (isset($this->loadedDynamicParameters[$name])) {
            return $this->loadedDynamicParameters[$name] ? $this->dynamicParameters[$name] : $this->getDynamicParameter($name);
        }

        return $this->parameters[$name];
    }

    public function hasParameter($name)
    {
        $name = (string) $name;

        return isset($this->parameters[$name]) || isset($this->loadedDynamicParameters[$name]) || array_key_exists($name, $this->parameters);
    }

    public function setParameter($name, $value)
    {
        throw new LogicException('Impossible to call set() on a frozen ParameterBag.');
    }

    public function getParameterBag()
    {
        if (null === $this->parameterBag) {
            $parameters = $this->parameters;
            foreach ($this->loadedDynamicParameters as $name => $loaded) {
                $parameters[$name] = $loaded ? $this->dynamicParameters[$name] : $this->getDynamicParameter($name);
            }
            $this->parameterBag = new FrozenParameterBag($parameters);
        }

        return $this->parameterBag;
    }

    private $loadedDynamicParameters = [];
    private $dynamicParameters = [];

    /**
     * Computes a dynamic parameter.
     *
     * @param string $name The name of the dynamic parameter to load
     *
     * @return mixed The value of the dynamic parameter
     *
     * @throws InvalidArgumentException When the dynamic parameter does not exist
     */
    private function getDynamicParameter($name)
    {
        throw new InvalidArgumentException(sprintf('The dynamic parameter "%s" must be defined.', $name));
    }

    /**
     * Gets the default parameters.
     *
     * @return array An array of the default parameters
     */
    protected function getDefaultParameters()
    {
        return [
            'viewsDir' => 'C:\\xampp\\htdocs\\ft/resources/views/',
            'salt' => '4e46c93890f89ff4dd3e41513c377ba11fa495a42d26ab1342c49086ae7c630fc91e0d',
            'minLength' => 5,
            'session_options' => [
                'name' => 'LOCALHOSTSESSION',
                'use_strict_mode' => true,
                'gc_probability' => 0,
                'cookie_lifetime' => 1810,
                'cookie_samesite' => 'Strict',
                'sid_length' => 48,
                'sid_bits_per_character' => 6,
            ],
        ];
    }
}
