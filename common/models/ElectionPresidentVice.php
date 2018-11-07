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
 */
class ElectionPresidentVice extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%election_president_vice}}';
    }

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
        return $this->hasOne(Country::class, ['country_id' => 'election_president_vice_country_id']);
    }
}
