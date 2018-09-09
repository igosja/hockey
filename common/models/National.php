<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class National
 * @package common\models
 *
 * @property integer $national_id
 * @property integer $national_country_id
 * @property integer $national_finance
 * @property integer $national_mood_rest
 * @property integer $national_mood_super
 * @property integer $national_national_type_id
 * @property integer $national_power_c_16
 * @property integer $national_power_c_21
 * @property integer $national_power_c_27
 * @property integer $national_power_s_16
 * @property integer $national_power_s_21
 * @property integer $national_power_s_27
 * @property integer $national_power_v
 * @property integer $national_power_vs
 * @property integer $national_stadium_id
 * @property integer $national_user_id
 * @property integer $national_vice_id
 * @property integer $national_visitor
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
                ['national_national_type_id'],
                'in',
                'range' => NationalType::find()->select(['national_type_id'])->column()
            ],
            [['national_country_id'], 'in', 'range' => Country::find()->select(['country_id'])->column()],
            [
                [
                    'national_id',
                    'national_finance',
                    'national_mood_rest',
                    'national_mood_super',
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
