<?php

namespace VS\Framework\Controller;

use VS\Framework\Routing\Router;
use VS\Framework\User\Account;
use VS\Framework\User\User;

class Users extends Controller
{
    public function show()
    {
        $username = $this->args['username'] ?? Account::user('username') ?? false;
        if (!$username) {
            Router::redirect('/browse');
        }

        $data = new \stdClass();
        $data->user = new User($username, 6);

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