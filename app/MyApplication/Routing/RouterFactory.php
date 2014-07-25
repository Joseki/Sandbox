<?php

namespace MyApplication;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;
use Nette\Caching\IStorage;

/**
 * Router factory.
 */
class RouterFactory
{
    /** @var \Nette\Caching\Cache */
    private $cache;

    const ROUTER_CACHE_KEY = 'router';

    private $version;



    function __construct(IStorage $storage, $version)
    {
        $this->cache = new Nette\Caching\Cache($storage, self::ROUTER_CACHE_KEY);
        $this->version = $version;
    }



    /**
     * @return \Nette\Application\IRouter
     */
    public function createRouter()
    {
//        if (($router = $this->cache->load($this->version)) === null) {
            $router = new RouteList();
            $router[] = $module = new RouteList();
            $module[] = new Route('<module>/<presenter>/<action>[/<id>]', [
                'presenter' => 'Homepage',
                'action' => 'default',
            ]);
            $module[] = new Route('<presenter>/<action>[/<id>]', [
                'module' => 'Front',
                'presenter' => 'Homepage',
                'action' => 'default'
            ]);
            $router[] = new Route('index.php', 'Front:Homepage:default', Route::ONE_WAY);

//            $this->cache->save($this->version, $router);
//        }
        return $router;
    }

}
