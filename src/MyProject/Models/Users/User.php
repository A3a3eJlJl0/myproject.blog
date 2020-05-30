<?php

namespace MyProject\Models\Users;

use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Models\ActiveRecordEntity;

class User extends ActiveRecordEntity
{
    protected $nickname;
    protected $email;
    protected $isConfirmed;
    protected $role;
    protected $passwordHash;
    protected $authToken;
    protected $createdAt;

    public static function getTableName(): string
    {
        return 'users';
    }


    static public function signUp(array $userData): self
    {
        if(empty($userData['nickname'])) {
            throw new InvalidArgumentException('Не передан nickname');
        }

        if(!preg_match('/^[a-zA-Z0-9]+$/', $userData['nickname'])) {
            throw new InvalidArgumentException('nickname может содержать только символы латинского алфавита и цифры');
        }

        if(empty($userData['email'])) {
            throw new InvalidArgumentException('Не передан email');
        }

        if(empty($userData['password'])) {
            throw new InvalidArgumentException('Не передан password');
        }

        if(mb_strlen($userData['password']) < 8){
            throw new InvalidArgumentException('Password должен быть не менее 8 символов');
        }

        if(static::findOneByColumn('nickname', $userData['nickname']) !== null){
            throw new InvalidArgumentException('Пользователь с таким nickname уже существует');
        }

        if(static::findOneByColumn('email', $userData['email']) !== null){
            throw new InvalidArgumentException('Пользователь с таким email уже существует');
        }

        $user = new User();
        $user->nickname = $userData['nickname'];
        $user->email = $userData['email'];
        $user->passwordHash = password_hash($userData['password'], PASSWORD_DEFAULT);
        $user->isConfirmed = false;
        $user->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
        $user->role = 'user';
        $user->save();

        return $user;
    }

    public function activate()
    {
        $this->isConfirmed = true;
        $this->save();
    }

    public function getNickname()
    {
        return $this->nickname;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getIsConfirmed()
    {
        return $this->isConfirmed;
    }
}