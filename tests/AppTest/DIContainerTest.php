<?php declare(strict_types = 1);

namespace AppTest;

use App\DIContainer;
use PHPUnit\Framework\TestCase;
use Mockery;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Yaml\Yaml;

final class DIContainerTest extends TestCase
{
    use AbstractTrait;

    const SERVICES_FILE = 'services.yml';

    private $config;
    private $cacheContainerConfig;
    private $container;

    protected $appDi;

    public function setUp() : void
    {
        $this->config = [
            'dir' => [
                'root' => dirname(__DIR__) . '/..//',
                'cache' => dirname(__DIR__) . '/../storage/tmp/',
                'views' => dirname(__DIR__) . '/../resources/views/',
                'config' => dirname(__DIR__) .'/../storage/tmp/',
            ],
            'isDebug' => true,
            'hashids' => [
                'salt' => $this->faker('password'),
                'minLength' => $this->faker('randomDigitNotNull')
            ],
            'session' => [
                'name' => $this->faker('name'),
                'maxlife' => 1800,
                'samesite' => 'Strict'
            ]
        ];

        $this->AppDi = new DIContainer($this->config);
    }

    public function testInstance() : void
    {
        $this->assertInstanceOf(DIContainer::class, $this->AppDi);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testIsServeicesFileExistsInTemp() : void
    {
        // check if services file not exists in storage/tmp/
        if(!file_exists(
            $this->config['dir']['config'] . self::SERVICES_FILE
        )) {
            // copy the real file to be able to change without
            // affecting the app
            copy(
                $this->config['dir']['root'] . 'config/' . self::SERVICES_FILE,
                $this->config['dir']['config'] . self::SERVICES_FILE
            );
            // link all directory to Root by going out 2 leveles
            // from /storage/tmp/ to Root/
            $this->alterYamlFile();
        }
    }

    public function testGetContainer() : void
    {
        $this->container = $this->AppDi->getContainer();

        $this->assertInstanceOf(
            Container::class,
            $this->container
        );

        // test with disabled debug mode
        $this->config['isDebug'] = false;
        $this->AppDi = new DIContainer($this->config);
        $this->container = $this->AppDi->getContainer();

        $this->assertInstanceOf(
            Container::class,
            $this->container
        );
    }

    public function testAfterUpdateingServicesFile() : void
    {
        $this->updateServiceFile();

        $this->AppDi = new DIContainer($this->config);
        $this->container = $this->AppDi->getContainer();

        $this->assertInstanceOf(
            Container::class,
            $this->container
        );
    }

    /**
     * this will alter all directroies in yaml file 
     * to go two steps out of current directory 
     * which is /storage/tmp/ to Root Directory
     *
     * @return void
     */
    private function alterYamlFile() : void
    {
        // turn yaml file into array for easy acsess and update
        $yaml = Yaml::parseFile($this->config['dir']['config'] . self::SERVICES_FILE);

        // loop through container array services
        foreach ($yaml['services'] as $y => $arr) {
            // check if an resource key exists
            if (isset($arr['resource'])) {
                // alter it to link root directory 
                // out from /storage/tmp/
                $arr['resource'] = '../' . $arr['resource'];
                $yaml['services'][$y] = $arr;
            } elseif (isset($arr['class'])) {
                // check if and class key exists
                // replace out directory to 2 levels
                // as /storage/tmp/ ==> root directory
                if (preg_match("/\.\.\//", $arr['class'])) {
                    // check if class has '../' direcory outer
                    $arr['class'] = '../' . $arr['class'];
                }
                $yaml['services'][$y] = $arr;
            }
        }

        // save the updated yaml file
        file_put_contents(
            $this->config['dir']['config'] . self::SERVICES_FILE,
            Yaml::dump($yaml)
        );
    }

    /**
     * make an change to services file 
     * turn lazy tage to it`s opposet
     *
     * @return void
     */
    private function updateServiceFile() : void
    {
        // turn yaml file into array for easy acsess and update
        $yaml = Yaml::parseFile($this->config['dir']['config'] . self::SERVICES_FILE);

        // loop through container array services
        foreach ($yaml['services'] as $y => $arr) {
            if (isset($arr['lazy'])) $arr['lazy'] = !$arr['lazy'];
            $yaml['services'][$y] = $arr;
        }

        // save the updated yaml file
        file_put_contents(
            $this->config['dir']['config'] . self::SERVICES_FILE,
            Yaml::dump($yaml)
        );
    }
}