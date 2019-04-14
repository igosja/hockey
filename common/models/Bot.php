<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class Bot
 * @package common\models
 *
 * @property int $bot_id
 * @property int $bot_date
 * @property int $bot_user_id
 *
 * @property User $user
 */
class Bot extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%bot}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'bot_id',
                    'bot_date',
                    'bot_user_id',
                ],
                'integer'
            ],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['user_id' => 'bot_user_id']);
    }
}
