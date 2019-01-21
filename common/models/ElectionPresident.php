<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class ElectionPresident
 * @package common\models
 *
 * @property int $election_president_id
 * @property int $election_president_country_id
 * @property int $election_president_date
 * @property int $election_president_election_status_id
 *
 * @property ElectionPresidentApplication[] $application
 * @property Country $country
 * @property ElectionStatus $electionStatus
 */
class ElectionPresident extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%election_president}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'election_president_id',
                    'election_president_country_id',
                    'election_president_date',
                    'election_president_election_status_id',
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
                $this->election_president_election_status_id = ElectionStatus::CANDIDATES;
                $this->election_president_date = time();
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
            $count = count($application->electionPresidentVote);
            $result[] = [
                'count' => $count,
                'user' => $application->election_president_application_user_id ? $application->user->userLink() : 'Потив всех',
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
            ElectionPresidentApplication::class,
            ['election_president_application_election_id' => 'election_president_id']
        );
    }

    /**
     * @return ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::class, ['country_id' => 'election_president_country_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getElectionStatus()
    {
        return $this->hasOne(ElectionStatus::class, ['election_status_id' => 'election_president_election_status_id']);
    }
}
