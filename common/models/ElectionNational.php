<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

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
 * @property National $national
 */
class ElectionNational extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%election_national}}';
    }

    /**
     * @return array
     */
    public function rules(): array
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
     * @return ActiveQuery
     */
    public function getApplication(): ActiveQuery
    {
        return $this->hasMany(
            ElectionNationalApplication::class,
            ['election_national_application_election_id' => 'election_national_id']
        );
    }

    /**
     * @return ActiveQuery
     */
    public function getNational(): ActiveQuery
    {
        return $this->hasOne(National::class, ['national_id' => 'election_national_national_type_id']);
    }
}
