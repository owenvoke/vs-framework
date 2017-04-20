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

        // Authentication
        $Route->any('/login', [self::CONTROLLERS . 'Auth', 'login']);
        $Route->any('/register', [self::CONTROLLERS . 'Auth', 'register']);
        $Route->any('/logout', [self::CONTROLLERS . 'Auth', 'logout']);

        // Generic Fallback Route
        $Route->any(
            '/*',
            function () {
                $error_route = self::CONTROLLERS . 'Main';
                (new $error_route)->error();
            }
        );

        return $Route;
    }
}