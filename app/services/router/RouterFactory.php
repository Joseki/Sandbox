<?php

namespace App;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;



/**
 * Router factory.
 */
class RouterFactory
{

	/**
	 * @return \Nette\Application\IRouter
	 */
	public function createRouter()
	{
		$router = new RouteList();
		$router[] = $module = new RouteList('Cron');
		$module[] = new Route('cron/<presenter>/<action>[/<id>]', 'Homepage:default');
		$router[] = $module = new RouteList('App');
		$module[] = new Route('app/<presenter>/<action>[/<id>]', 'Homepage:default');
		$router[] = $module = new RouteList('Admin');
		$module[] = new Route('admin/<presenter>/<action>[/<id>]', 'Homepage:default');
		$router[] = $module = new RouteList('Front');
		$module[] = new Route('index.php', 'Homepage:default', Route::ONE_WAY);
		$module[] = new Route('article/<id>', 'Article:default');
		$module[] = new Route('filtr/<id>', 'Filter:default');
		$module[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');
		return $router;
	}

}
