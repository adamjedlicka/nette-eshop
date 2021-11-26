<?php

declare(strict_types=1);

namespace App\Router;

use Nette\Application\Routers\RouteList;
use Nette\StaticClass;

final class RouterFactory
{
	use StaticClass;

	public static function createRouter(): RouteList
	{
		$storefront = new RouteList('Storefront');
		$storefront->addRoute('<presenter=Homepage>/<action=default>[/<id>]');

		$router = new RouteList();
		$router->add($storefront);
		return $router;
	}
}
