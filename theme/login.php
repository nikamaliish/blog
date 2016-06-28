<?php
if (!isset($login)) {
    $login = '';
}
if (!isset($error)) {
    $error = '';
}
?>
<h3>Авторизация</h3>

<form method="post">
    <input type="text" name="login" placeholder="Введите логин" required value="<?= $login ?>">
    <input type="password" name="password" placeholder="Введите пароль" required>
    <label>  Запомнить меня<input type="checkbox" name="remember"></label>
    <input type="submit" name="submit">
</form>
<?php if ($error) : ?>
    <p style="color: red">
        <?= $error ?>
    </p>
<?php endif; ?>
