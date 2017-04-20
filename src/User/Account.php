<?php

namespace VS\User;

class Account
{
    protected $id;
    protected $username;
    protected $email;

    public static $valid = false;

    public function __construct()
    {
        session_start();

        if (isset($_SESSION['user']->id)) {
            self::$valid = true;
        }
    }

    public function login($username, $password)
    {
        // TODO: Implement Login
    }

    public function logout()
    {
        $_SESSION['user'] = null;
    }

    public function register($data)
    {
        // TODO: Implement Registering
    }
}