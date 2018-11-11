<?php

namespace common\models;

/**
 * Class Poll
 * @package common\models
 *
 * @property int $vote_user_id
 * @property int $vote_user_answer_id
 * @property int $vote_user_date
 * @property int $vote_user_user_id
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
            [['vote_user_id', 'vote_user_answer_id', 'vote_user_date', 'vote_user_user_id'], 'integer'],
        ];
    }
}
