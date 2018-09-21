<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class UserRole
 * @package common\models
 *
 * @property int $user_role_id
 * @property string $user_role_name
 */
class UserRole extends ActiveRecord
{
    const ADMIN = 3;
    const USER = 1;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%user_role}}';
    }

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
