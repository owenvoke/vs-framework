<?php

namespace VS\Framework\Routing;

use System\Route;

/**
 * Class PluginRoute
 */
class PluginRoute
{
    /**
     * @param Route $Route
     * @return Route
     */
    public static function Register(Route $Route)
    {
        return $Route;
    }
}