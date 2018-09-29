<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class National
 * @package common\models
 *
 * @property int $national_id
 * @property int $national_country_id
 * @property int $national_finance
 * @property int $national_mood_rest
 * @property int $national_mood_super
 * @property int $national_national_type_id
 * @property int $national_power_c_16
 * @property int $national_power_c_21
 * @property int $national_power_c_27
 * @property int $national_power_s_16
 * @property int $national_power_s_21
 * @property int $national_power_s_27
 * @property int $national_power_v
 * @property int $national_power_vs
 * @property int $national_stadium_id
 * @property int $national_user_id
 * @property int $national_vice_id
 * @property int $national_visitor
 *
 * @property Country $country
 * @property NationalType $nationalType
 * @property WorldCup $worldCup
 */
class National extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%national}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'national_id',
                    'national_country_id',
                    'national_finance',
                    'national_mood_rest',
                    'national_mood_super',
                    'national_national_type_id',
                    'national_power_c_16',
                    'national_power_c_21',
                    'national_power_c_27',
                    'national_power_s_16',
                    'national_power_s_21',
                    'national_power_s_27',
                    'national_power_v',
                    'national_power_vs',
                    'national_stadium_id',
                    'national_user_id',
                    'national_vice_id',
                    'national_visitor',
                ],
                'integer'
            ],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCountry(): ActiveQuery
    {
        return $this->hasOne(Country::class, ['country_id' => 'national_country_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getNationalType(): ActiveQuery
    {
        return $this->hasOne(NationalType::class, ['national_type_id' => 'national_national_type_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getWorldCup(): ActiveQuery
    {
        return $this
            ->hasOne(WorldCup::class, ['world_cup_national_id' => 'national_id'])
            ->andWhere(['world_cup_season_id' => Season::getCurrentSeason()]);
    }
}
