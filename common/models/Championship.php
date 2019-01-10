<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class Championship
 * @package common\models
 *
 * @property int $championship_id
 * @property int $championship_country_id
 * @property int $championship_difference
 * @property int $championship_division_id
 * @property int $championship_game
 * @property int $championship_loose
 * @property int $championship_loose_overtime
 * @property int $championship_loose_shootout
 * @property int $championship_pass
 * @property int $championship_place
 * @property int $championship_point
 * @property int $championship_score
 * @property int $championship_season_id
 * @property int $championship_team_id
 * @property int $championship_win
 * @property int $championship_win_overtime
 * @property int $championship_win_shootout
 *
 * @property Country $country
 * @property Division $division
 * @property Team $team
 */
class Championship extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%championship}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'championship_id',
                    'championship_country_id',
                    'championship_difference',
                    'championship_division_id',
                    'championship_game',
                    'championship_loose',
                    'championship_loose_overtime',
                    'championship_loose_shootout',
                    'championship_pass',
                    'championship_place',
                    'championship_point',
                    'championship_score',
                    'championship_season_id',
                    'championship_team_id',
                    'championship_win',
                    'championship_win_overtime',
                    'championship_win_shootout',
                ],
                'integer'
            ],
            [
                [
                    'championship_country_id',
                    'championship_division_id',
                    'championship_season_id',
                    'championship_team_id'
                ],
                'required'
            ],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::class, ['country_id' => 'championship_country_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getDivision()
    {
        return $this->hasOne(Division::class, ['division_id' => 'championship_division_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasOne(Team::class, ['team_id' => 'championship_team_id']);
    }
}
