<?php
use models\User;

class Templater
{
    public $viewsPath = __DIR__ . '/../themes';

    function template($fileName, $vars = array())
    {
// Установка переменных для шаблона.
        foreach ($vars as $k => $v) {
            $$k = $v;
        }
// Генерация HTML в строку.
        ob_start();
        include $fileName;
        return ob_get_clean();
    }

//
// Буферизация страницы
//
    function template_page($main, $params)
    {
        ob_start();
        if (isset($_SESSION['login']))
            echo $this->template('theme/header.php', ['is_guest' => User::isGuest(), 'login' => $_SESSION['login']]);
        else
            echo $this->template('theme/header.php', ['is_guest' => User::isGuest(), 'login' => ""]);

        echo $this->template($main, $params);
        echo $this->template('theme/footer.php');
        return ob_get_clean();
    }
}