<?php

namespace common\models;

use common\components\HockeyHelper;
use yii\db\ActiveQuery;

/**
 * Class ElectionPresidentApplication
 * @package common\models
 *
 * @property int $election_president_application_id
 * @property int $election_president_application_date
 * @property int $election_president_application_election_id
 * @property string $election_president_application_text
 * @property int $election_president_application_user_id
 *
 * @property ElectionPresident $electionPresident
 * @property ElectionPresidentVote[] $electionPresidentVote
 * @property User $user
 */
class ElectionPresidentApplication extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%election_president_application}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'election_president_application_id',
                    'election_president_application_date',
                    'election_president_application_election_id',
                    'election_president_application_user_id',
                ],
                'integer'
            ],
            [['election_president_application_text'], 'required']
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
                $this->election_president_application_date = time();
            }
            $this->election_president_application_text = HockeyHelper::clearBbCodeBeforeSave($this->election_president_application_text);
            return true;
        }
        return false;
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'election_president_application_text' => 'Программа',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getElectionPresident()
    {
        return $this->hasOne(
            ElectionPresident::class,
            ['election_president_id' => 'election_president_application_election_id']
        );
    }

    /**
     * @return ActiveQuery
     */
    public function getElectionPresidentVote()
    {
        return $this->hasMany(
            ElectionPresidentVote::class,
            ['election_president_vote_application_id' => 'election_president_application_id']
        );
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['user_id' => 'election_president_application_user_id']);
    }
}
