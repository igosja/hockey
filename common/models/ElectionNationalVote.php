<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class ElectionNationalVote
 * @package common\models
 *
 * @property int $election_national_vote_id
 * @property int $election_national_vote_application_id
 * @property int $election_national_vote_user_id
 * @property int $election_national_vote_vote
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
                    'election_national_vote_user_id',
                    'election_national_vote_vote',
                ],
                'integer'
            ],
        ];
    }
}
