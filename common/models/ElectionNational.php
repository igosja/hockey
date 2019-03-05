<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class ElectionNational
 * @package common\models
 *
 * @property int $election_national_id
 * @property int $election_national_country_id
 * @property int $election_national_date
 * @property int $election_national_election_status_id
 * @property int $election_national_national_type_id
 *
 * @property ElectionNationalApplication[] $application
 * @property ElectionStatus $electionStatus
 * @property National $national
 */
class ElectionNational extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%election_national}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'election_national_id',
                    'election_national_country_id',
                    'election_national_date',
                    'election_national_election_status_id',
                    'election_national_national_type_id',
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
                $this->election_national_election_status_id = ElectionStatus::CANDIDATES;
                $this->election_national_date = time();
            }
            return true;
        }
        return false;
    }

    /**
     * @return array
     */
    public function applications()
    {
        $result = [];
        $total = 0;
        foreach ($this->application as $application) {
            $count = count($application->electionNationalVote);
            $result[] = [
                'count' => $count,
                'user' => $application->election_national_application_user_id ? $application->user->userLink() : 'Потив всех',
            ];
            $total = $total + $count;
        }
        foreach ($result as $key => $value) {
            $result[$key]['percent'] = $total ? round($result[$key]['count'] / $total * 100) : 0;
        }
        usort($result, function ($a, $b) {
            return $b['count'] > $a['count'] ? 1 : 0;
        });
        return $result;
    }

    /**
     * @return ActiveQuery
     */
    public function getApplication()
    {
        return $this->hasMany(
            ElectionNationalApplication::class,
            ['election_national_application_election_id' => 'election_national_id']
        );
    }

    /**
     * @return ActiveQuery
     */
    public function getElectionStatus()
    {
        return $this->hasOne(ElectionStatus::class, ['election_status_id' => 'election_national_election_status_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getNational()
    {
        return $this->hasOne(National::class, [
            'national_country_id' => 'election_national_country_id',
            'national_national_type_id' => 'election_national_national_type_id'
        ]);
    }
}
