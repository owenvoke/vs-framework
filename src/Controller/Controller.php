<?php

namespace VS\Controller;

use System\Request;

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
     * Controller constructor.
     */
    public function __construct()
    {
        foreach (Request::instance() as $item => $value) {
            $this->$item = $value;
        }

        $this->smarty = new \Smarty();
        $this->smarty->setTemplateDir(ROOT_PATH . 'templates');
        $this->smarty->setCompileDir(ROOT_PATH . 'templates_c');
    }
}