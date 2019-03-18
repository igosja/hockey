<?php

namespace common\models;

use common\components\HockeyHelper;
use yii\db\ActiveQuery;

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
class ElectionNationalViceApplication extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%election_national_vice_application}}';
    }

    /**
     * @return array
     */
    public function rules()
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
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->election_national_vice_application_date = time();
            }
            $this->election_national_vice_application_text = HockeyHelper::clearBbCodeBeforeSave($this->election_national_vice_application_text);
            return true;
        }
        return false;
    }

    /**
     * @return ActiveQuery
     */
    public function getElectionNationalVice()
    {
        return $this->hasOne(
            ElectionNationalVice::class,
            ['election_national_vice_id' => 'election_national_vice_application_election_id']
        );
    }

    /**
     * @return ActiveQuery
     */
    public function getElectionNationalViceVote()
    {
        return $this->hasMany(
            ElectionNationalViceVote::class,
            ['election_national_vice_vote_application_id' => 'election_national_vice_application_id']
        );
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['user_id' => 'election_national_vice_application_user_id']);
    }
}
