<h1>Редактирование статьи</h1>
<?php if (isset($error)) echo "<b style='color: red;'>$error</b>"?>

<form method="post">
    Название:
    <br/>
    <input class="form-item" type="text" name="title" value="<?= $title ?>" />
    <br/>
    <br/>
    Содержание:
    <br/>
    <textarea class="form-item" name="content"><?= $content ?></textarea>
    <br/><br/>
    <input type="submit" name="edit" value="Редактировать" />
    <input type="submit" name="delete" value="Удалить">
</form>
