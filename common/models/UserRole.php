<?php

namespace common\models;

/**
 * Class UserRole
 * @package common\models
 *
 * @property int $user_role_id
 * @property string $user_role_name
 */
class UserRole extends AbstractActiveRecord
{
    const ADMIN = 5;
    const EDITOR = 3;
    const MODERATOR = 4;
    const SUPPORT = 2;
    const USER = 1;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['user_role_id'], 'integer'],
            [['user_role_name'], 'required'],
            [['user_role_name'], 'string'],
        ];
    }
}
