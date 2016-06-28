<?php
namespace controllers;

use models\Post;
use models\User;
use models\Session;

class DefaultController extends AbstractController
{
    public function actionIndex()
    {
        $model = Post::model();
        $all = $model->all();

        return $this->render(['articles' => $all]);
    }

    public function actionLogin()
    {
        if (!User::isGuest()) {
            return $this->redirect('/projects/PHP/Lessons/Lesson_2.5/index.php');
        }

        // Проверка на существование $_POST['login'] и $_POST['password']

        if ('POST' != $_SERVER['REQUEST_METHOD']) {
            return $this->render();
        }

        $model = User::model()->find(['login' => $_POST['login']]);
        if (!$model) {
            return $this->render(['error' => 'Пользователь не найден. <a href=?a=regist>Зарегистрироваться</a>', 'login' => $_POST['login']]);
        }

        if ($model->password != User::getPasswordHash($_POST['password'])) {
            return $this->render(['error' => 'Пароль не верен', 'login' => $_POST['login']]);
        }

        $_SESSION['user'] = $model;
        $_SESSION['login'] = $this->fixObject($_SESSION['user'])->login;

        $session_model = Session::model()->find(['user_id' => $model->id]);
        if (!$session_model) {
            $session_model = Session::model();
            $session_model->user_id = $model->id;
            $session_model->date_updated = date('Y-m-d H:i:s');
            $session_model->auth_token = Session::generate();
            $session_model->save();
        } else {
            $session_model->date_updated = date('Y-m-d H:i:s');
            $session_model->save();
        }

        if (isset($_POST['remember'])) {
            setcookie('auth_token', $session_model->auth_token, time() + (86400 * 30));
        }

        return $this->redirect('index.php');
    }

    public function actionLogout()
    {
        unset($_SESSION['user']);
        setcookie('auth_token', null);
        return $this->redirect('index.php');
    }

    public function actionRegistr()
    {
        if (!User::isGuest()) {
            return $this->redirect('/projects/PHP/Lessons/Lesson_2.5/index.php');
        }

        // Проверка $_POST['login'] и $_POST['password']

        if ('POST' != $_SERVER['REQUEST_METHOD']) {
            return $this->render();
        }

        if ($_POST['password'] != $_POST['re-password']) {
            return $this->render(['error' => 'Пароль в двух полях не совпадает', 'login' => $_POST['login']]);
        }

        $model = User::model()->find(['login' => $_POST['login']]);
        if ($model) {
            return $this->render(['error' => 'Пользователь с таким именем уже существует', 'login' => $_POST['login']]);
        }

        $user_model = User::model();
        $user_model->login = $_POST['login'];
        $user_model->password = User::getPasswordHash($_POST['password']);

        if (!$user_model->save())
            return $this->render(['error' => 'Произошла ошибка при регистрации. Попаробуйте еще раз', 'login' => $_POST['login']]);
        else
            return $this->redirect('?a=login');
    }

    private function fixObject(&$object)
    {
        if (!is_object($object) && gettype($object) == 'object')
            return ($object = unserialize(serialize($object)));
        return $object;
    }
}