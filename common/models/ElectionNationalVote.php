<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class ElectionNationalVote
 * @package common\models
 *
 * @property int $election_national_vote_id
 * @property int $election_national_vote_application_id
 * @property int $election_national_vote_date
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
                    'election_national_vote_date',
                    'election_national_vote_user_id',
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
                $this->election_national_vote_date = time();
            }
            return true;
        }
        return false;
    }
}
