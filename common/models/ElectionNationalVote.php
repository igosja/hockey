<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class ElectionNationalPlayer
 * @package common\models
 *
 * @property int $election_national_vote_id
 * @property int $election_national_vote_application_id
 * @property int $election_national_vote_vote
 * @property int $election_national_vote_user_id
 */
class ElectionNationalVote extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%election_national_vote}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'election_national_vote_id',
                    'election_national_vote_application_id',
                    'election_national_vote_vote',
                    'election_national_vote_user_id',
                ],
                'integer'
            ],
        ];
    }
}
