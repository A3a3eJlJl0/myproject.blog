<?php

namespace MyProject\Controllers;

use MyProject\Models\Articles\Article;
use MyProject\Views\View;

class MainController
{
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../Templates');
    }

    public function main()
    {
        $articles = Article::findAll();
        $this->view->renderHtml('main.php', ['articles' => $articles]);
    }
}