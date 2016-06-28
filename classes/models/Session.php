<?php
namespace models;

class Session extends AbstractModel
{
    public $id;
    public $user_id;
    public $date_updated;
    public $auth_token;

    public function getTableName()
    {
        return 'sessions';
    }

    public function getAttributes()
    {
        return ['id', 'user_id', 'date_updated', 'auth_token'];
    }

    public static function getPasswordHash($string)
    {
        return md5(md5($string));
    }

    public static function generate()
    {
        $string = '';
        $symbols = range('a', 'z');
        for ($i = 0; $i < 40; $i++) {
            $string .= $symbols[array_rand($symbols)];
        }
        return $string;
    }

    public static function authByCookie()
    {
        if (!isset($_COOKIE['auth_token'])) {
            return;
        }

        $session_model = Session::model()->find(['auth_token' => $_COOKIE['auth_token']]);
        if (!$session_model) {
            return;
        }

        $user_model = User::model()->one($session_model->id);

        $_SESSION['user'] = $user_model;
    }
}

