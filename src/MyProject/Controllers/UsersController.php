<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Models\Users\User;
use MyProject\Models\Users\UserActivationService;
use MyProject\Services\EmailSender;
use MyProject\Views\View;

class UsersController
{
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../Templates');
    }

    public function signUp()
    {
        if (!empty($_POST)) {
            try {
                $user = User::signUp($_POST);
            }
            catch (InvalidArgumentException $e){
                $this->view->renderHtml('Users/signUp.php', ['error' => $e->getMessage()]);
                return;
            }
        }

        if($user instanceof User){
            $code = UserActivationService::createActivationCode($user);
            EmailSender::send($user, 'Activation', 'UserActivation.php', ['code' => $code, 'userId' => $user->getId()]);

            $this->view->renderHtml('Users/signUpSuccessful.php');
            return;
        }

        $this->view->renderHtml('Users/signUp.php');

    }

    public function activate(int $userId, string $activationCode)
    {
        $user = User::getById($userId);

        if(UserActivationService::checkActivationCode($user, $activationCode)){
            $user->activate();
            echo 'OK!';
        }
    }
}
