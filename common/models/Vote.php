<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Vote
 * @package common\models
 *
 * @property integer $vote_id
 * @property integer $vote_country_id
 * @property integer $vote_date
 * @property string $vote_text
 * @property integer $vote_user_id
 * @property integer $vote_vote_status_id
 */
class Vote extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%vote}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['vote_country_id'], 'in', 'range' => Country::find()->select(['country_id'])->column()],
            [['vote_user_id'], 'in', 'range' => User::find()->select(['user_id'])->column()],
            [['vote_vote_status_id'], 'in', 'range' => VoteStatus::find()->select(['vote_status_id'])->column()],
            [['vote_id', 'vote_date'], 'integer'],
            [['vote_text'], 'required'],
            [['vote_text'], 'safe'],
            [['vote_text'], 'trim'],
        ];
    }
}
