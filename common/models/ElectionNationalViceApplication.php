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
            [['election_national_vice_application_text'], 'required']
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
            $this->election_national_vice_application_text = HockeyHelper::clearBbCodeBeforeSave($this->election_national_vice_application_text);
            return true;
        }
        return false;
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'election_national_vice_application_text' => 'Программа',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getElectionNationalVice(): ActiveQuery
    {
        return $this->hasOne(
            ElectionNationalVice::class,
            ['election_national_vice_id' => 'election_national_vice_application_election_id']
        )->cache();
    }

    /**
     * @return ActiveQuery
     */
    public function getElectionNationalViceVote(): ActiveQuery
    {
        return $this->hasMany(
            ElectionNationalViceVote::class,
            ['election_national_vice_vote_application_id' => 'election_national_vice_application_id']
        );
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['user_id' => 'election_national_vice_application_user_id'])->cache();
    }
}
