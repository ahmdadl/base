<?php declare(strict_types=1);

namespace App\Controllers;

use App\View\FrontRenderInterface;

class AssetController
{

    private $view;

    public function __construct(FrontRenderInterface $view)
    {
        $this->view = $view;
    }

    public function fonts(array $param) : void
    {
        $dir = dirname(__DIR__) . '/../public/assets/webfonts/' . $param['font'];
        echo file_get_contents($dir);
    }

    public function postImg(array $param) : void
    {
        $dir = dirname(dirname(__DIR__)) . '/storage/posts/' . $param['img'];
        echo file_get_contents($dir);
    }

    public function handelErrors(array $param)
    {
        $page = isset($param['num']) ? $param['num'] : 404;

        return $this->view->render('error/p'. $page);
    }
}