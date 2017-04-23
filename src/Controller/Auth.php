<?php

namespace VS\Framework\Controller;

use VS\Framework\Routing\Router;
use VS\Framework\User\Account;

class Auth extends Controller
{
    public function __construct()
    {
        Parent::__construct();
        if (Account::auth()) {
            Router::redirect();
        }
    }

    public function login()
    {
        $data = new \stdClass();
        $data->response = true;
        $data->username = $this->body['username'] ?? '';
        $data->password = $this->body['password'] ?? '';

        if ($data->username != '' && $data->password != '') {
            $data->response = $this->user->login($data->username, $data->password);
        }

        $this->smarty->display(
            'auth/login.tpl',
            [
                'data' => $data
            ]
        );
    }

    public function register()
    {
        $data = new \stdClass();
        $data->response = true;
        $data->username = $this->body['username'] ?? '';
        $data->email = $this->body['email'] ?? '';
        $data->password = $this->body['password'] ?? '';
        $data->password_confirm = $this->body['password_confirm'] ?? '';

        if ($data->username != '' && $data->email != '' && $data->password != '' && $data->password == $data->password_confirm) {
            $data->response = $this->user->register($data);
        }

        $this->smarty->display(
            'auth/register.tpl',
            [
                'data' => $data
            ]
        );
    }

    public function logout()
    {
        $this->user->logout();
    }
}