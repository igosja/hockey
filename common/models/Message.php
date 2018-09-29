<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Message
 * @package common\models
 *
 * @property int $message_id
 * @property int $message_date
 * @property int $message_read
 * @property int $message_support
 * @property string $message_text
 * @property int $message_user_id_from
 * @property int $message_user_id_to
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
                [
                    'message_id',
                    'message_date',
                    'message_read',
                    'message_support',
                    'message_user_id_from',
                    'message_user_id_to',
                ],
                'integer'
            ],
            [['message_text', 'message_user_id_to'], 'required'],
            [['message_text'], 'safe'],
            [['message_text'], 'trim'],
        ];
    }
}
