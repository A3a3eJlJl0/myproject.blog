<?php

use MyProject\Models\Articles\Article;

spl_autoload_register(function (string $className) {
    require_once __DIR__ . '/../src/' . $className . '.php';
});

$article = new Article();
$article->setName('Выдры напали на бобров.');
$article->setText('Сегодян в полночь при загадочных обстоятельствах...');
$article->setAuthorId(1);
$article->setCreatedAt('2020-05-04 18:26:45');
$article->save();
