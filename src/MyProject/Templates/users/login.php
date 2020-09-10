<?php include __DIR__ . '/../header.php' ?>
    <div style="text-align: center;">
        <h1>Авторизация</h1>
        <?php if(!empty($error)): ?>
            <div style="background-color: red;"> Ошибка: <?= $error ?> </div>
        <?php endif; ?>
        <form action="/users/login" method="post">
            <label>
                email
                <input type="email" name="email" value="<?= $_POST['email'] ?? ''?>">
            </label>
            <br><br>
            <label>
                пароль
                <input type="password" name="password" value="<?= $_POST['password'] ?? ''?>">
            </label>
            <br><br>
            <input type="submit" value="Войти">
        </form>
    </div>
<?php include __DIR__ . '/../footer.php' ?>