<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class ElectionPresidentViceApplication
 * @package common\models
 *
 * @property int $election_president_vice_application_id
 * @property int $election_president_vice_application_date
 * @property int $election_president_vice_application_election_id
 * @property string $election_president_vice_application_text
 * @property int $election_president_vice_application_user_id
 *
 * @property ElectionPresidentVice $electionPresidentVice
 * @property ElectionPresidentViceVote[] $electionPresidentViceVote
 * @property User $user
 */
class ElectionPresidentViceApplication extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%election_president_vice_application}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'election_president_vice_application_id',
                    'election_president_vice_application_date',
                    'election_president_vice_application_election_id',
                    'election_president_vice_application_user_id',
                ],
                'integer'
            ],
            [['election_president_vice_application_text'], 'safe']
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
                $this->election_president_vice_application_date = time();
            }
            return true;
        }
        return false;
    }

    /**
     * @return ActiveQuery
     */
    public function getElectionPresidentVice()
    {
        return $this->hasOne(
            ElectionPresidentVice::class,
            ['election_president_vice_id' => 'election_president_vice_application_election_id']
        );
    }

    /**
     * @return ActiveQuery
     */
    public function getElectionPresidentViceVote()
    {
        return $this->hasMany(
            ElectionPresidentViceVote::class,
            ['election_president_vice_vote_application_id' => 'election_president_vice_application_id']
        );
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['user_id' => 'election_president_vice_application_user_id']);
    }
}
