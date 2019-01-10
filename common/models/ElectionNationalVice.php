<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class ElectionNationalVice
 * @package common\models
 *
 * @property int $election_national_vice_id
 * @property int $election_national_vice_country_id
 * @property int $election_national_vice_date
 * @property int $election_national_vice_election_status_id
 * @property int $election_national_vice_national_type_id
 *
 * @property ElectionNationalViceApplication[] $application
 * @property National $national
 */
class ElectionNationalVice extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%election_national_vice}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'election_national_vice_id',
                    'election_national_vice_country_id',
                    'election_national_vice_date',
                    'election_national_vice_election_status_id',
                    'election_national_vice_national_type_id',
                ],
                'integer'
            ],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getApplication()
    {
        return $this->hasMany(
            ElectionNationalViceApplication::class,
            ['election_national_vice_application_election_id' => 'election_national_vice_id']
        );
    }

    /**
     * @return ActiveQuery
     */
    public function getNational()
    {
        return $this->hasOne(National::class, ['national_id' => 'election_national_vice_national_id']);
    }
}
