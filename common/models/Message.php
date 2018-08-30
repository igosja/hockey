<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Message
 * @package common\models
 *
 * @property integer $message_id
 * @property integer $message_date
 * @property integer $message_read
 * @property integer $message_support
 * @property string $message_text
 * @property integer $message_user_id_from
 * @property integer $message_user_id_to
 */
class Message extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%message}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                ['message_user_id_from', 'message_user_id_to'],
                'in',
                'range' => User::find()->select(['user_id'])->column()
            ],
            [['message_id', 'message_date', 'message_read', 'message_support'], 'integer'],
            [['message_text', 'message_user_id_to'], 'required'],
            [['message_text'], 'safe'],
            [['message_text'], 'trim'],
        ];
    }
}
