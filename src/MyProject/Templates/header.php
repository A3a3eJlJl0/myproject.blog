<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <?php if(!empty($title)): ?>
        <title> <?= $title?> </title>
    <?php else : ?>
        <title> Мой Блог </title>
    <?php endif; ?>
    <link rel="stylesheet" href="/style.css">
</head>
<body>

<table class="layout">
    <tr>
        <td colspan="2" class="header">
            Мой блог
        </td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: right">
            <?php if(!empty($user)): ?>
                Привет, <?= $user->getNickname() ?> | <a href="/users/logout">Выйти</a>
            <?php else: ?>
                <a href="/users/login">Войдите на сайт</a>
                |
                <a href="/users/register">Регистрация</a>
            <?php endif ?>
        </td>
    </tr>
    <tr>
        <td>