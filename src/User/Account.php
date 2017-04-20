<?php

namespace VS\User;

use VS\Config;

class Account
{
    private $db;

    public function __construct()
    {
        session_start();
        $this->db = Config::connect();
    }

    public static function auth()
    {
        if (isset($_SESSION['user']->id) && $_SESSION['user']->id > 0) {
            return true;
        }

        return false;
    }

    public function login($username, $password)
    {
        if (!$username || !$password) {
            return false;
        }

        $stmt = $this->db->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->bindParam(':username', $username, \PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_OBJ);

        if ($result && password_verify($password, $result->password)) {
            unset($result->password);
            $_SESSION['user'] = $result;

            header('Location: /');
            return true;
        } else {
            return false;
        }
    }

    public function logout()
    {
        $_SESSION['user'] = null;
        header('Location: /login');
    }

    public function register($data)
    {
        if (!$data->username || !$data->password) {
            return false;
        }

        if ($data->password == $data->password_confirm) {
            $data->password = password_hash($data->password, PASSWORD_DEFAULT);

            $stmt = $this->db->prepare('INSERT INTO users (username, password, email) VALUES (:username, :password, :email)');
            $stmt->bindParam(':username', $data->username, \PDO::PARAM_STR);
            $stmt->bindParam(':password', $data->password, \PDO::PARAM_STR);
            $stmt->bindParam(':email', $data->email, \PDO::PARAM_STR);
            $stmt->execute();

            $result = $this->db->lastInsertId();
            if ($result != 0) {
                header('Location: /login');
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    public static function user($key)
    {
        return $_SESSION['user']->$key ?? '';
    }
}