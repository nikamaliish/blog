<?php
if (!isset($login)) {
    $login = '';
}
if (!isset($error)) {
    $error = '';
}
?>
<div class="container">
    <h3>Регистрация</h3>
    <form method="post">
        <input type="text" placeholder="Введите логин" name="login"
               value="<?= $login ?>" required><br><br>
        <input type="password" placeholder="Введите пароль" name="password" required><br><br>
        <input type="password" placeholder="Повторите пароль" name="re-password" required><br><br>
        <input type="submit">
    </form>
</div>
<?php if ($error) : ?>
    <p style="color: red">
        <?= $error ?>
    </p>
<?php endif;

