<?php

namespace VS\Routing;

use System\App;
use System\Request;
use System\Route;

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

        $route->end();
    }
}