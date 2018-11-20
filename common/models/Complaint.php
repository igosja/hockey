<?php

namespace common\models;

/**
 * Class Complaint
 * @package common\models
 *
 * @property int $complaint_id
 * @property int $complaint_date
 * @property int $complaint_forum_message_id
 * @property int $complaint_user_id
 */
class Complaint extends AbstractActiveRecord
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
            [['complaint_forum_message_id', 'complaint_id', 'complaint_date', 'complaint_user_id'], 'integer'],
            [['complaint_forum_message_id'], 'required'],
        ];
    }
}
