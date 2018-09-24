<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class ElectionNationalViceApplication
 * @package common\models
 *
 * @property int $election_national_vice_application_id
 * @property int $election_national_vice_application_date
 * @property int $election_national_vice_application_election_id
 * @property string $election_national_vice_application_text
 * @property int $election_national_vice_application_user_id
 *
 * @property ElectionNationalVice $electionNationalVice
 * @property ElectionNationalViceVote[] $electionNationalViceVote
 * @property User $user
 */
class ElectionNationalViceApplication extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%election_national_vice_application}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'election_national_vice_application_id',
                    'election_national_vice_application_date',
                    'election_national_vice_application_election_id',
                    'election_national_vice_application_user_id',
                ],
                'integer'
            ],
            [['election_national_vice_application_text'], 'safe']
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
                $this->election_national_vice_application_date = time();
            }
            return true;
        }
        return false;
    }

    /**
     * @return ActiveQuery
     */
    public function getElectionNationalVice(): ActiveQuery
    {
        return $this->hasOne(
            ElectionNationalVice::class,
            ['election_national_vice_id' => 'election_national_vice_application_election_id']
        );
    }

    /**
     * @return ActiveQuery
     */
    public function getElectionNationalViceVote(): ActiveQuery
    {
        return $this->hasMany(
            ElectionNationalVote::class,
            ['election_national_vice_vote_application_id' => 'election_national_vice_application_id']
        );
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['user_id' => 'election_national_vice_application_user_id']);
    }
}
