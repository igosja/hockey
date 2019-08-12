<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class ElectionPresidentVice
 * @package common\models
 *
 * @property int $election_president_vice_id
 * @property int $election_president_vice_country_id
 * @property int $election_president_vice_date
 * @property int $election_president_vice_election_status_id
 *
 * @property ElectionPresidentViceApplication[] $application
 * @property Country $country
 * @property ElectionStatus $electionStatus
 */
class ElectionPresidentVice extends AbstractActiveRecord
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'election_president_vice_id',
                    'election_president_vice_country_id',
                    'election_president_vice_date',
                    'election_president_vice_election_status_id',
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
                $this->election_president_vice_election_status_id = ElectionStatus::CANDIDATES;
                $this->election_president_vice_date = time();
            }
            return true;
        }
        return false;
    }

    /**
     * @return array
     */
    public function applications(): array
    {
        $result = [];
        $total = 0;
        foreach ($this->application as $application) {
            $count = count($application->electionPresidentViceVote);
            $result[] = [
                'count' => $count,
                'user' => $application->election_president_vice_application_user_id ? $application->user->userLink() : 'Против всех',
                'logo' => $application->election_president_vice_application_user_id ? $application->user->smallLogo() : '',
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
    public function getApplication(): ActiveQuery
    {
        return $this->hasMany(
            ElectionPresidentViceApplication::class,
            ['election_president_vice_application_election_id' => 'election_president_vice_id']
        );
    }

    /**
     * @return ActiveQuery
     */
    public function getCountry(): ActiveQuery
    {
        return $this->hasOne(Country::class, ['country_id' => 'election_president_vice_country_id'])->cache();
    }

    /**
     * @return ActiveQuery
     */
    public function getElectionStatus(): ActiveQuery
    {
        return $this->hasOne(ElectionStatus::class, ['election_status_id' => 'election_president_vice_election_status_id']);
    }
}
