<?php

namespace VS\Framework\Routing;

use System\App;
use System\Request;
use System\Route;
use VS\Framework\Controller\Main;

/**
 * Class Router
 */
class Router
{
    public static function Init()
    {
        $app = App::instance();
        $app->request = Request::instance();
        $app->route = Route::instance($app->request);

        $route = Routes::Register($app->route);

        $RouteLoader = new RouteLoader();
        $route = $RouteLoader->autoload($route);

        // Generic Fallback Route
        $route->any(
            '/*',
            function () {
                (new Main)->error();
            }
        );

        $route->end();
    }

    public static function redirect($location = '/')
    {
        if (!headers_sent()) {
            header('Location: ' . $location);
        }
    }
}