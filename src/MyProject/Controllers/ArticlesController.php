<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\NotFoundException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;


class ArticlesController extends AbstractController
{
    private $db;

    public function view(int $articleId)
    {
        $article = Article::getById($articleId);

        if($article === null) {
            throw new NotFoundException();
        }

        $this->view->renderHtml('articleView.php', ['article' => $article]);
    }

    public function edit(int $articleId)
    {
        $article = Article::getById($articleId);
        if($article === null) {
            throw new NotFoundException();
        }

        $article->setName('Новая статья...');
        $article->setText('Новый текст...');

        $article->save();
    }

    public function add()
    {
        $author = User::getById(1);

        $article = new Article();
        $article->setName('Ахахах');
        $article->setText('Оххохох');
        $article->setAuthor($author);

        $article->save();
    }

    public function delete(int $articleId)
    {
        $article = Article::getById($articleId);
        if($article != null) {
            $article->delete();
            var_dump($article);
        }
        else{
            throw new NotFoundException();
        }
    }
}