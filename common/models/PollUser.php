<?php

namespace common\models;

use common\components\HockeyHelper;
use Yii;

/**
 * Class Poll
 * @package common\models
 *
 * @property int $poll_user_date
 * @property int $poll_user_poll_answer_id
 * @property int $poll_user_user_id
 */
class PollUser extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%poll_user}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['poll_user_poll_answer_id', 'poll_user_date', 'poll_user_user_id'], 'integer'],
            [['poll_user_poll_answer_id'], 'required'],
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->poll_user_date = HockeyHelper::unixTimeStamp();
                $this->poll_user_user_id = Yii::$app->user->id;
            }
            return true;
        }
        return false;
    }
}
