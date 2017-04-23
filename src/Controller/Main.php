<?php

namespace VS\Framework\Controller;

class Main extends Controller
{
    public function index()
    {
        $this->smarty->display('index.tpl');
    }

    public function error($code = 404, $text = 'Page not found.', $data = false)
    {
        $error = new \stdClass();
        $error->code = $code;
        $error->text = $text;
        $error->data = $data;

        $this->smarty->display(
            'error.tpl',
            [
                'error' => $error
            ]
        );
    }
}