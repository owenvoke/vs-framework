<?php

namespace VS\Routing;

use System\Route;

/**
 * Class Routes
 */
class Routes
{
    const CONTROLLERS = '\\VS\\Controller\\';

    /**
     * @param Route $Route
     * @return Route
     */
    public static function Register(Route $Route)
    {
        // Custom Routes
        $Route->any('/', [self::CONTROLLERS . 'Main', 'index']);

        // Generic Fallback Route
        $Route->any('/*', [self::CONTROLLERS . 'Main', 'error']);

        return $Route;
    }
}