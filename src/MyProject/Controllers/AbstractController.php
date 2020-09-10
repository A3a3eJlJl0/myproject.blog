<?php

namespace MyProject\Controllers;

use MyProject\Services\UserAuthService;
use MyProject\Views\View;

class AbstractController
{
    protected $user;

    protected $view;

    public function __construct()
    {
        $this->user = UserAuthService::getUserByToken();
        $this->view = new View(__DIR__ . '/../Templates');
        $this->view->setExtraVar('user', $this->user);
    }
}