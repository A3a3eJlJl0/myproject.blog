<?php include __DIR__.'/../header.php' ?>
<div style="text-align: center;">
    <h1>Регистрация</h1>
    <?php if(!empty($error)): ?>
    <div style="background-color: red; padding: 5px; margin: 15px;"> <?= $error ?> </div>
    <?php endif; ?>
    <form method="post">
        <label>Никнейм<input type="text" name="nickname" value="<?= $_POST['nickname'] ?>"></label>
        <br>
        <label>e-mail<input type="email" name="email" value="<?= $_POST['email'] ?>"></label>
        <br>
        <label>Пароль<input type="password" name="password" value="<?= $_POST['password'] ?>"></label>
        <br>
        <input type="submit" value="Зарегистрироваться">
    </form>
</div>
<?php include __DIR__.'/../footer.php' ?>