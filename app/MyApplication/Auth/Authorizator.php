<?php

namespace MyApplication\Auth;

use MyApplication\Navigation\Section;
use Nette\Application\IRouter;
use Nette\Caching\Cache;
use Nette\Caching\IStorage;
use Nette\Http\Request as HttpRequest;
use Nette\Object;
use Nette\Security\IAuthorizator;

class Authorizator extends Object implements IAuthorizator
{

    /** @var \MyApplication\Auth\User */
    private $user;

    /** @var \Nette\Application\Request */
    private $request;

    /** @var \Nette\Http\Request */
    private $httpRequest;

    /** @var \Nette\Application\IRouter */
    private $router;

    /** @var Cache */
    private $cache;

    const AUTHORIZATOR_CACHE_KEY = 'authorizator';



    public function __construct(
        HttpRequest $httpRequest,
        IRouter $router,
        IStorage $storage
    ) {
        $this->httpRequest = $httpRequest;
        $this->router = $router;
        $this->cache = new Cache($storage, self::AUTHORIZATOR_CACHE_KEY);
    }



    public function isAllowed($user, $resource, $privilege)
    {
        $this->user = $user;

        $allow = true;
        if ($resource instanceof Section) {
            foreach ($resource->restrictions as $restriction) {
                $callbackName = 'check' . ucfirst($restriction->name);
                if (!$this->$callbackName()) {
                    $allow = false;
                    break;
                }
            }
        }

        return $allow;
    }



    /**
     * @return \Nette\Application\Request
     */
    public function getRequest()
    {
        if (!$this->request) {
            $this->request = $this->router->match($this->httpRequest);
        }
        return $this->request;
    }

}
