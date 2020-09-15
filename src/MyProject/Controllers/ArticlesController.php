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

        if ($article === null) {
            throw new NotFoundException();
        }

        $this->view->renderHtml('article/view.php', ['article' => $article, 'user' => $this->user]);
    }

    public function edit(int $articleId)
    {
        $article = Article::getById($articleId);
        if ($article === null) {
            throw new NotFoundException();
        }

        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        if (!empty($_POST)) {
            try {
                $article->updateFromArray($_POST, $this->user);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('article/add.php', ['error' => $e->getMessage()]);
            }
            header('Location: /articles/' . $article->getId(), true, 302);
            exit();
        }
        $this->view->renderHtml('article/edit.php', ['article' => $article]);
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
                $this->view->renderHtml('article/add.php', ['error' => $e->getMessage()]);
            }
            header('Location: /articles/' . $article->getId(), true, 302);
            exit();
        }
        $this->view->renderHtml('article/add.php');
    }

    public function delete(int $articleId)
    {
        $article = Article::getById($articleId);
        if ($article != null) {
            $article->delete();
        } else {
            throw new NotFoundException();
        }
    }
}