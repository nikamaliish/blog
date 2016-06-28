<?php
namespace controllers;

use models\Session;

abstract class AbstractController
{
    public $_action;
    public $_controllerId;

    public function beforeAction()
    {
        Session::authByCookie();
    }

    public function __call($name, $params)
    {
        return $this->errorHandler();
    }

    public function errorHandler() {
        return 'Нет такого метода';
    }

    public function render($params = [])
    {
        $templater = new \Templater();

        // /../views/post/index.php

        return $templater->template_page('theme/' . $this->_action . '.php', $params);
    }

    public function redirect($path)
    {
        header('Location: ' . $path);
        return true;
    }

}