<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Exceptions\UnauthorizedException;
use MyProject\Models\Articles\Article;


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
        if ($this->user === null) {
            throw new UnauthorizedException();
        }
        if (!empty($_POST)) {
            try {
                $article = Article::createFromArray($_POST, $this->user);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('articleAdd.php', ['error' => $e->getMessage()]);
            }
            header('Location: /articles/' . $article->getId(), true, 302);
            exit();
        }
        $this->view->renderHtml('articleAdd.php');
    }

    public function delete(int $articleId)
    {
        $article = Article::getById($articleId);
        if($article != null) {
            $article->delete();
        }
        else{
            throw new NotFoundException();
        }
    }
}