<?php declare(strict_types=1);

namespace App\Controllers;

class AssetController
{
    public function fonts(array $param) : void
    {
        $dir = dirname(__DIR__) . '/../public/assets/webfonts/' . $param['font'];
        echo file_get_contents($dir);
    }
}