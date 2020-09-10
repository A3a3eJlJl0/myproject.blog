<?php

namespace MyProject\Controllers;

use League\CommonMark\Block\Element\AbstractBlock;
use MyProject\Exceptions\DbException;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Models\Users\User;
use MyProject\Models\Users\UserActivationService;
use MyProject\Services\EmailSender;
use MyProject\Services\UserAuthService;
use MyProject\Views\View;

class UsersController extends AbstractController
{

    public function signUp()
    {
        if (!empty($_POST)) {
            try {
                $user = User::signUp($_POST);
            }
            catch (InvalidArgumentException $e){
                $this->view->renderHtml('users/signUp.php', ['error' => $e->getMessage()]);
                return;
            }
        }

        if($user instanceof User){
            $code = UserActivationService::createActivationCode($user);
            EmailSender::send($user, 'Activation', 'UserActivation.php', ['code' => $code, 'userId' => $user->getId()]);

            $this->view->renderHtml('users/signUpSuccessful.php');
            return;
        }

        $this->view->renderHtml('users/signUp.php');

    }

    public function activate(int $userId, string $activationCode)
    {
        try {
            $user = User::getById($userId);

            if(empty($user)) {
                throw new DbException('Пользователь не найден.');
            }

            if($user->getIsConfirmed()) {
                throw new InvalidArgumentException();
            }
            if (UserActivationService::checkActivationCode($user, $activationCode)) {
                $user->activate();
                UserActivationService::removeActivationCode($user, $activationCode);
                $this->view->renderHtml('/users/ActivationSuccess.php');
            }
        }
        catch (DbException $e) {
            $this->view->renderHtml('/users/ActivationError.php', ['error' => $e->getMessage()]);
        }
        catch (InvalidArgumentException $e) {
            $this->view->renderHtml('/users/ActivationAlready.php');
        }
    }
}
