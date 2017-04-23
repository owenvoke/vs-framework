<?php

namespace VS\Framework\Controller;

use System\Request;
use VS\Framework\Config;
use VS\Framework\User\Account;

/**
 * Class Controller
 */
class Controller
{
    protected $query;
    protected $body;
    protected $files;
    protected $args;
    /**
     * @var \Smarty
     */
    public $smarty;
    /**
     * @var Account
     */
    public $user;
    /**
     * @var \PDO
     */
    public $db;

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
        $this->smarty->setPluginsDir(SRC_PATH . 'SmartyPlugins');

        $this->db = Config::connect();
    }
}