<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <title>PHP. Уровень 2</title>
    <meta content="text/html; charset=utf-8" http-equiv="content-type">
    <link rel="stylesheet" type="text/css" media="screen" href="theme/style.css"/>
</head>
<body>
<h1>Блог</h1>

<?php if (!$is_guest) echo "<p>Вы зашли как: " . $login; ?>
<?php if ($is_guest) : ?>
    <p>[<a href='?a=login'> Войти </a>]</p>
<?php else : ?>
   [<a href='?a=logout'> Выйти </a>]</p>
<?php endif;?>

<a href="index.php">Главная</a> |
<a href="?a=editor&c=post">Консоль редактора</a>
<hr/>
</body>
