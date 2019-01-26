<?php

namespace common\models;

use Yii;

/**
 * Class Complaint
 * @package common\models
 *
 * @property int $complaint_id
 * @property int $complaint_date
 * @property int $complaint_forum_message_id
 * @property int $complaint_ready
 * @property int $complaint_user_id
 *
 * @property User $user
 */
class Complaint extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%complaint}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['complaint_forum_message_id', 'complaint_id', 'complaint_date', 'complaint_user_id'], 'integer'],
            [['complaint_forum_message_id'], 'required'],
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->complaint_date = time();
                $this->complaint_user_id = Yii::$app->user->id;
            }
            return true;
        }
        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['user_id' => 'complaint_user_id']);
    }
}
