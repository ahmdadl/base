<?php declare(strict_types=1);

namespace App\Util;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\Translation\Translator;

class Trans
{
    public $tras;
    
    public function __construct() {}

    /**
     * set translator loacle based on request
     *
     * @param string $local
     * @return void
     */
    public function setLocal(string $local = 'en')
    {
        if (strpos($local, 'ar') !== false) {
            $local = 'ar';
        } else {
            $local = 'en';
        }

        $this->trans = new Translator($local);
        $this->setLoaders();
        $this->setResorce($local);
    }

    /**
     * set loaders for translator
     *
     * @return void
     */
    private function setLoaders() : void
    {
        $this->trans->addLoader('array', new ArrayLoader());
    }

    /**
     * set all langauge resources
     *
     * @param string $local
     * @return void
     */
    private function setResorce(string $local) : void
    {
        $this->trans->addResource('array', $this->loadArray('en'), 'en');

        $this->trans->addResource('array', $this->loadArray('ar'), 'ar');
    }

    /**
     * load langauge file from lang resources
     *
     * @param string $name
     * @return void
     */
    private function loadArray(string $name) : array
    {
        $langDir = dirname(dirname(__DIR__)) . '/resources/lang/';

        return include_once $langDir . $name . '/index.php';
    }
}