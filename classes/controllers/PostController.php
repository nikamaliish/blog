<?php
namespace controllers;

use models\Post;
use models\User;

class PostController extends AbstractController
{
    public function actionIndex()
    {
        $model = Post::model();
        $all = $model->all();
        return $this->render(['articles' => $all]);
    }

    public function actionView()
    {
        if (!$_SESSION['user']->hasPriv($_GET['c'] . '_' . $_GET['a'])) {
            $error = "Недостаточно прав для выполнения данного действия";
            exit;
        }

        $model = Post::model();
        $article = $model->one($_GET['id']);

        return $this->render(['title' => $article->title, 'date' => $article->date,
            'content' => $article->content]);
    }

    public function actionNew()
    {
        $error = "";

        if (!$_SESSION['user']->hasPriv($_GET['c'] . '_' . $_GET['a'])) {
            $error = "Недостаточно прав для выполнения данного действия";
            header('Location: index.php?a=editor&c=post');
            exit;
        }

        $model = Post::model();

        if (isset($_POST['new'])) {
            $model->title = trim($_POST['title']);
            $model->content = trim($_POST['content']);
            $model->date = date('Y-m-d');

            if ((empty($_POST['title'])) || (empty($_POST['content']))) {
                $error = "Заполните все поля!";
            } else {
                $model->save();
                header('Location: index.php?a=editor&c=post');
                exit;
            }
        }

        return $this->render(['title' => $model->title, 'content' => $model->content, 'error' => $error]);
    }

    public function actionEditor()
    {
        $model = Post::model();
        $all = $model->all();
        return $this->render(['articles' => $all]);
    }

    public
    function actionEdit()
    {
        $error = "";
        if (!$_SESSION['user']->hasPriv($_GET['c'] . '_' . $_GET['a'])) {
            echo "Недостаточно прав для выполнения данного действия";
            exit;
        }
        $model = Post::model();
        $article = $model->one($_GET['id']);

        if (isset($_POST['delete'])) {
            if (!$_SESSION['user']->hasPriv($_GET['c'] . '_delete')) {
                $error = "Недостаточно прав для выполнения данного действия";

            } else {
                $model->delete();
                header('Location: index.php?a=editor&c=post');
                exit;
            }
        }

        if (isset($_POST['edit'])) {
            $model->title = trim($_POST['title']);
            $model->content = trim($_POST['content']);

            if ((empty($_POST['title'])) || (empty($_POST['content']))) {
                $error = "Заполните все поля!";
            } else {
                $model->save();
                header('Location: index.php?a=editor&c=post');
                exit;
            }
        }

        return $this->render(['title' => $article->title, 'date' => $article->date,
            'content' => $article->content, 'error' => $error]);
    }
}