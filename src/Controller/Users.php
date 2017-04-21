<?php

namespace VS\Controller;

use VS\Routing\Router;
use VS\User\Account;
use VS\User\User;

class Users extends Controller
{
    public function show()
    {
        $username = $this->args['username'] ?? Account::user('username') ?? false;
        if (!$username) {
            Router::redirect('/browse');
        }

        $data = new \stdClass();
        $data->user = new User($username);

        if (!$data->user->id) {
            $data->user = false;
        }
        $this->smarty->display(
            'users/show.tpl',
            [
                'data' => $data
            ]
        );
    }
}