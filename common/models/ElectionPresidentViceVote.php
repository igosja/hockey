<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class ElectionPresidentViceVote
 * @package common\models
 *
 * @property int $election_president_vice_vote_id
 * @property int $election_president_vice_vote_application_id
 * @property int $election_president_vice_vote_date
 * @property int $election_president_vice_vote_user_id
 * @property int $election_president_vice_vote_vote
 */
class ElectionPresidentViceVote extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%election_president_vice_vote}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'election_president_vice_vote_id',
                    'election_president_vice_vote_application_id',
                    'election_president_vice_vote_date',
                    'election_president_vice_vote_user_id',
                    'election_president_vice_vote_vote',
                ],
                'integer'
            ],
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
                $this->election_president_vice_vote_date = time();
            }
            return true;
        }
        return false;
    }
}
