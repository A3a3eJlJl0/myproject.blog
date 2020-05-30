<?php

namespace MyProject\Models\Users;

use MyProject\Exceptions\DbException;
use MyProject\Services\Db;

class UserActivationService
{
    private const TABLE_NAME = 'activation_codes';

    public static function createActivationCode(User $user): string
    {
        $code = bin2hex(random_bytes(16));

        $db = Db::getInstance();
        $db->query(
            'insert into `' . self::TABLE_NAME . '` (`user_id`, `code`) values (:user_id, :code);',
            [':user_id' => $user->getId(), ':code' => $code]
        );
        return $code;
    }

    public static function checkActivationCode(User $user, string $code): bool
    {
        $db = Db::getInstance();
        $result = $db->query(
            'select * from ' . self::TABLE_NAME . ' where user_id = :user_id and code = :code;',
            [':user_id' => $user->getId(), ':code' => $code]
        );

        if (empty($result)) {
            throw new DbException('Неверный код активации.');
        }
        return true;
    }

    public static function removeActivationCode(User $user, string $code)
    {
        $db = Db::getInstance();
        $db->query(
            'delete from ' . self::TABLE_NAME . ' where user_id = :user_id and code = :code;',
            [':user_id' => $user->getId(), ':code' => $code]
        );
    }
}
