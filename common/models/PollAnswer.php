<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class PollAnswer
 * @package common\models
 *
 * @property int $poll_answer_id
 * @property string $poll_answer_text
 * @property int $poll_answer_poll_id
 *
 * @property PollUser[] $pollUser
 */
class PollAnswer extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%poll_answer}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['poll_answer_id', 'poll_answer_poll_id'], 'integer'],
            [['poll_answer_text'], 'required'],
            [['poll_answer_text'], 'safe'],
            [['poll_answer_text'], 'trim'],
        ];
    }

    /**
     * @return bool
     */
    public function beforeDelete(): bool
    {
        if (parent::beforeDelete()) {
            PollUser::deleteAll(['poll_user_poll_answer_id' => $this->poll_answer_id]);
            return true;
        }
        return false;
    }

    /**
     * @return ActiveQuery
     */
    public function getPollUser(): ActiveQuery
    {
        return $this->hasMany(PollUser::class, ['poll_user_poll_answer_id' => 'poll_answer_id']);
    }
}
