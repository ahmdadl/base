<?php declare(strict_types = 1);

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;
use App\View\FrontRenderInterface;
use Hashids\Hashids;
use App\Util\AppSession;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController
{
    protected $request;
    protected $view;
    protected $hashid;
    protected $session;

    public function __construct(
        Request $request,
        FrontRenderInterface $view,
        Hashids $hashid,
        AppSession $session
    ) {
        $this->request = $request;
        $this->view = $view;
        $this->hashid = $hashid;
        $this->session = $session;
        $this->session->sessStart();
    }

    /**
     * retrives input data from request object
     *
     * @param string $key
     * @param string $req use query for GET request
     * @return string|null
     */
    public function getRequest(
        string $key,
        string $req = 'request'
    ) : ?string {
        $q = $this->request->{$req}->get($key);
        if (!$q || empty(trim($q))) {
            return null;
        } 

        return htmlspecialchars((string)$q, ENT_QUOTES);
    }

    public function show(array $params = []) : Response
    {
        return $this->view->rename('');
    }

    public function decode(string $hashedId) : int
    {
        return $this->hashid->decode($hashedId)[0];
    }

    public function encode(int $id) : string
    {
        return $this->hashid->encode($id);
    }
}