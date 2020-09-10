<?php

namespace MyProject\Services;

use MyProject\Models\Users\User;

class UserAuthService
{

    public static function createToken(User $user) : void
    {
        $token = $user->getId() . ':' .  $user->getAuthToken();
        setcookie('token', $token, 0, '/', '', false, true);
    }

    public static function deleteToken() : void
    {
        unset($_COOKIE['token']);
        setcookie('token', null, false, '/');
    }

    public static function getUserByToken(): ?User
    {
        $token = $_COOKIE['token'] ?? null;

        if (!$token) {
            return null;
        }

        [$userId, $authToken] = explode(':', $token, 2);

        $user = User::getById($userId);

        if (!$user) {
            return null;
        }

        if ($user->getAuthToken() !== $authToken) {
            return null;
        } 
        
        return $user;
    }
}