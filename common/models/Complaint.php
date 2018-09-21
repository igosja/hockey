<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Complaint
 * @package common\models
 *
 * @property int $complaint_id
 * @property int $complaint_date
 * @property int $complaint_forum_message_id
 * @property int $complaint_user_id
 */
class Complaint extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%complaint}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                ['complaint_forum_message_id'],
                'in',
                'range' => ForumMessage::find()->select(['forum_message_id'])->column()
            ],
            [['complaint_user_id'], 'in', 'range' => User::find()->select(['user_id'])->column()],
            [['complaint_id', 'complaint_date'], 'integer'],
            [['complaint_forum_message_id'], 'required'],
        ];
    }
}
