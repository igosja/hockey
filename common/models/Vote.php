<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Vote
 * @package common\models
 *
 * @property int $vote_id
 * @property int $vote_country_id
 * @property int $vote_date
 * @property string $vote_text
 * @property int $vote_user_id
 * @property int $vote_vote_status_id
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
            [['vote_id', 'vote_country_id', 'vote_date', 'vote_user_id', 'vote_vote_status_id'], 'integer'],
            [['vote_text'], 'required'],
            [['vote_text'], 'safe'],
            [['vote_text'], 'trim'],
        ];
    }
}
