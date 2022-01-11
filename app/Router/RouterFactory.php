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
        $admin = new RouteList('Admin');
        $admin->addRoute('admin/<presenter=Dashboard>/<action=default>[/<id>]');

        $storefront = new RouteList('Storefront');
        $storefront->addRoute('product/<slug>', 'Product:view');
        $storefront->addRoute('category/<slug>', 'Category:view');
        $storefront->addRoute('cms/<slug>', 'CmsPage:view');
        $storefront->addRoute('<presenter=Homepage>/<action=default>[/<id>]');

        $router = new RouteList();
        $router->add($admin);
        $router->add($storefront);
        return $router;
    }
}
