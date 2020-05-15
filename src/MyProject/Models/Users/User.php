<?php

namespace MyProject\Models\Users;

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

    /**
     * @return mixed
     */
    public function getNickname()
    {
        return $this->nickname;
    }
}