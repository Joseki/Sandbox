<?php

namespace Blog;

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



    function __construct(IStorage $storage)
    {
        $this->cache = new Nette\Caching\Cache($storage, self::ROUTER_CACHE_KEY);
    }



    /**
     * @param string $version
     * @param bool $debugMode
     * @return Nette\Application\IRouter
     */
    public function createRouter($version, $debugMode = false)
    {
        if ($debugMode || ($router = $this->cache->load($version)) === null) {
            $router = new RouteList();
            $router[] = $module = new RouteList('Application');
            $module[] = new Route('<module admin>/<presenter>/<action>[/<id>]', [
                'presenter' => 'Homepage',
                'action' => 'default',
            ]);
            $module[] = new Route('<presenter>/<action>[/<id>]', [
                'module' => 'Front',
                'presenter' => 'Homepage',
                'action' => 'default'
            ]);
            $router[] = new Route('index.php', 'Front:Homepage:default', Route::ONE_WAY);

            $this->cache->save($version, $router, array('version' => $version));
        }
        return $router;
    }

}
