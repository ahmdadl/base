<?php

declare(strict_types=1);

namespace App\View;

use Symfony\Component\HttpFoundation\{
    Request,
    Response
};
use App\Util\{
    AppSession,
    Password,
    Trans
};
use League\Plates\Engine;
use League\Plates\Extension\{
    Asset,
    URI
};
use App\View\FrontRenderTrait;
use ParsedownExtra;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\ArrayLoader;

class FrontRender implements FrontRenderInterface
{
    use FrontRenderTrait;

    private $requset;
    private $response;
    private $view;
    private $session;
    private $trans;

    public function __construct(
        Request $request,
        Response $response,
        Engine $view,
        AppSession $session,
        Trans $trans
    ) {
        $this->request = $request;
        $this->response = $response;
        $this->view = $view;
        $this->session = $session;
        $this->trans = $trans;

        // set translation locale
        $local = $this->request->getLocale() === 'ar' ? 'ar' : 'en';
        if (!$this->session->se->has('lang')) {
            $this->session->se->set('lang', $local);
        }
        $this->trans->setLocal($this->session->se->get('lang') ?? 'en');

        $this->configView();
    }

    public function render(string $template, array $params = [])
    {
        
        $this->response->setContent(
            $this->spaceless(
                $this->view->render($template, $params)
            )
        );

        $this->session->se->getFlashBag()->clear();
    }

    /**
     * config plates instance to load desired extension and functions
     *
     * @return void
     */
    private function configView(): void
    {
        // load Asset extension
        $this->view->loadExtension(new Asset(dirname(__DIR__) . '/../public/', false));

        // load URI extenssion
        $this->view->loadExtension(new URI($this->request->getPathInfo()));

        // create new escape function
        $this->view->registerFunction('es', [$this, 'es']);

        // create method function like laravel one
        $this->view->registerFunction('_method', [$this, '_method']);

        /**
         * create function to add csrf token
         * @link https://stackoverflow.com/questions/6287903/how-to-properly-add-csrf-token-using-php
         */
        $this->view->registerFunction('csrf', [$this, 'csrf']);

        // make session available to all views
        $this->view->addData(['session' => $this->session->se]);

        // make errors function
        $this->view->addData([
            'errors' => new class ($this->session->se)
            {
                private $session;

                public function __construct($session)
                {
                    $this->session = $session;
                }

                public function any() : bool
                {
                    return $this->session->getFlashBag()->has('danger');
                }

                public function has(string $key) : bool
                {
                    $k = $this->load($key, 'danger');
                    return true === $k;
                }

                public function get(string $key)
                {
                    return $this->load($key) ?? '';
                }

                public function getOld(string $key, string $default = '') : ?string
                {
                    return $this->load($key, 'old') ?? $default;
                }

                private function load(string $key, string $bag = 'danger') 
                {
                    return $this->session->getFlashBag()->peek($bag)[0]->{$key} ?? null;
                }
            }
        ]);

        /**
         * retrun translation
         */
        $this->view->registerFunction('__', function ($str) {
            return $this->trans->trans->trans($str);
        });

        /**
         * render markdown
         */
        $this->view->registerFunction('re', function ($md) {
            $parse = new ParsedownExtra();

            return $parse->text($md);
        });
    }
}
