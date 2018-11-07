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
 */
class ElectionPresident extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%election_president}}';
    }

    /**
     * @return array
     */
    public function rules(): array
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
     * @return ActiveQuery
     */
    public function getApplication(): ActiveQuery
    {
        return $this->hasMany(
            ElectionPresidentApplication::class,
            ['election_president_application_election_id' => 'election_president_id']
        );
    }

    /**
     * @return ActiveQuery
     */
    public function getCountry(): ActiveQuery
    {
        return $this->hasOne(Country::class, ['country_id' => 'election_president_country_id']);
    }
}
