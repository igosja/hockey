<?php

namespace common\models;

/**
 * Class ElectionPresidentVote
 * @package common\models
 *
 * @property int $election_president_vote_id
 * @property int $election_president_vote_application_id
 * @property int $election_president_vote_date
 * @property int $election_president_vote_user_id
 */
class ElectionPresidentVote extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%election_president_vote}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'election_president_vote_id',
                    'election_president_vote_date',
                    'election_president_vote_application_id',
                    'election_president_vote_user_id',
                ],
                'integer'
            ],
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
                $this->election_president_vote_date = time();
            }
            return true;
        }
        return false;
    }
}
