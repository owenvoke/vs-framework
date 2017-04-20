<?php

namespace VS\Controller;

class Auth extends Controller
{
    public function login()
    {
        $data = new \stdClass();
        $data->username = $this->body['username'] ?? '';
        $data->password = $this->body['password'] ?? '';

        if ($data->username && $data->password) {
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
        $data->username = $this->body['username'] ?? '';
        $data->password = $this->body['password'] ?? '';

        if ($data->username && $data->password) {
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