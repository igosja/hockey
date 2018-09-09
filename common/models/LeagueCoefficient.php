<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class LeagueCoefficient
 * @package common\models
 *
 * @property integer $league_coefficient_id
 * @property integer $league_coefficient_country_id
 * @property integer $league_coefficient_loose
 * @property integer $league_coefficient_loose_overtime
 * @property integer $league_coefficient_loose_shootout
 * @property integer $league_coefficient_point
 * @property integer $league_coefficient_season_id
 * @property integer $league_coefficient_team_id
 * @property integer $league_coefficient_win
 * @property integer $league_coefficient_win_overtime
 * @property integer $league_coefficient_win_shootout
 */
class LeagueCoefficient extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%league_coefficient}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'league_coefficient_id',
                    'league_coefficient_country_id',
                    'league_coefficient_loose',
                    'league_coefficient_loose_overtime',
                    'league_coefficient_loose_shootout',
                    'league_coefficient_point',
                    'league_coefficient_season_id',
                    'league_coefficient_team_id',
                    'league_coefficient_win',
                    'league_coefficient_win_overtime',
                    'league_coefficient_win_shootout',
                ],
                'integer'
            ],
        ];
    }
}
