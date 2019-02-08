<?php

namespace common\models;

use common\components\HockeyHelper;
use yii\db\ActiveQuery;

/**
 * Class ElectionNationalApplication
 * @package common\models
 *
 * @property int $election_national_application_id
 * @property int $election_national_application_date
 * @property int $election_national_application_election_id
 * @property string $election_national_application_text
 * @property int $election_national_application_user_id
 *
 * @property ElectionNational $electionNational
 * @property ElectionNationalPlayer[] $electionNationalPlayer
 * @property ElectionNationalVote[] $electionNationalVote
 * @property User $user
 */
class ElectionNationalApplication extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%election_national_application}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'election_national_application_id',
                    'election_national_application_date',
                    'election_national_application_election_id',
                    'election_national_application_user_id',
                ],
                'integer'
            ],
            [['election_national_application_text'], 'safe']
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
                $this->election_national_application_date = time();
            }
            $this->election_national_application_text = HockeyHelper::clearBbCodeBeforeSave($this->election_national_application_text);
            return true;
        }
        return false;
    }

    /**
     * @return ActiveQuery
     */
    public function getElectionNational()
    {
        return $this->hasOne(
            ElectionNational::class,
            ['election_national_id' => 'election_national_application_election_id']
        );
    }

    /**
     * @return ActiveQuery
     */
    public function getElectionNationalPlayer()
    {
        return $this->hasMany(
            ElectionNationalPlayer::class,
            ['election_national_player_application_id' => 'election_national_application_id']
        );
    }

    /**
     * @return ActiveQuery
     */
    public function getElectionNationalVote()
    {
        return $this->hasMany(
            ElectionNationalVote::class,
            ['election_national_vote_application_id' => 'election_national_application_id']
        );
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['user_id' => 'election_national_application_user_id']);
    }
}
