<?php

namespace VS;

/**
 * Class Config
 */
class Config
{
    // App Configuration
    const APP_NAME = 'VS';
    const MAX_UPLOAD_SIZE = 31457280; // Default to 30MB

    // Database Configuration
    const DB_DSN = 'mysql:host=localhost;dbname=vs';
    const DB_USER = 'root';
    const DB_PASS = 'root';

    /**
     * @var \PDO|null
     */
    protected static $conn;

    /**
     * @return \PDO
     */
    public static function connect()
    {
        if (!is_a(self::$conn, '\\PDO')) {
            self::$conn = new \PDO(Config::DB_DSN, Config::DB_USER, Config::DB_PASS);
        }

        return self::$conn;
    }
}