<?php

namespace VS\Controller;

use System\Request;
use VS\User\Account;

/**
 * Class Controller
 */
class Controller
{
    /**
     * @var \Smarty
     */
    public $smarty;
    /**
     * @var Account
     */
    public $user;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->user = new Account();
        foreach (Request::instance() as $item => $value) {
            $this->$item = $value;
        }

        $this->smarty = new \Smarty();
        $this->smarty->setTemplateDir(ROOT_PATH . 'templates');
        $this->smarty->setCompileDir(ROOT_PATH . 'templates_c');
    }
}