<?php

namespace MyProject\Controllers;

use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;
use MyProject\Views\View;

class ArticlesController
{
    private $view;
    private $db;

    public function __construct()
    {
        $this->view = new View(__DIR__.'/../../Templates');
    }

    public function view(int $articleId)
    {
        $article = Article::getById($articleId);
        $reflector = new \ReflectionObject($article);
        $properties = $reflector->getProperties();

        if($article === [])
        {
            $this->view->renderHtml('errors/404.php', [], 400);
            return;
        }

        $this->view->renderHtml('articleView.php', ['article' => $article]);
    }

    public function edit(int $articleId)
    {
        $article = Article::getById($articleId);
        if($article === null) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
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
            $this->view->renderHtml('errors/404.php', [], 404);
        }
    }
}