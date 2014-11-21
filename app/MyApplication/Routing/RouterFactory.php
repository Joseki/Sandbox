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

    /** @var bool */
    private $debug;



    function __construct($debug, IStorage $storage)
    {
        $this->cache = new Nette\Caching\Cache($storage, self::ROUTER_CACHE_KEY);
        $this->debug = $debug;
    }



    /**
     * @return Nette\Application\IRouter
     */
    public function createRouter()
    {
        if ($this->debug || ($router = $this->cache->load('router')) === null) {
            $router = new RouteList();
            $router[] = new Route('index.php', 'Front:Homepage:default', Route::ONE_WAY);
            $router[] = new Route('sign-in', 'Sign:in');
            $router[] = new Route('logout', 'Sign:out');
            $router[] = new Route('sitemap.xml', 'Sitemap:default');

            $router[] = $module = new RouteList('Admin');
            $module[] = new Route('admin/<presenter>/<action>[/<id>]', [
                'presenter' => 'Homepage',
                'action' => 'default',
            ]);

            $router[] = $module = new RouteList('Front');
            $module[] = new Route('<presenter>/<action>[/<id>]', [
                'presenter' => 'Homepage',
                'action' => 'default'
            ]);

            $this->cache->save('router', $router);
        }
        return $router;
    }

}
