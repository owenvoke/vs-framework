<?php

namespace VS\Routing;

use System\Route;
use VS\Controller\Main;

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

        // Videos
        $Route->any('/v/{hash}', [self::CONTROLLERS . 'Videos', 'show']);
        $Route->any('/upload', [self::CONTROLLERS . 'Videos', 'upload']);
        $Route->any('/videos/{hash}', [self::CONTROLLERS . 'Videos', 'display']);
        $Route->any('/thumbs/{hash}', [self::CONTROLLERS . 'Videos', 'thumb']);

        // Generic Fallback Route
        $Route->any(
            '/*',
            function () {
                (new Main)->error();
            }
        );

        return $Route;
    }
}