<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class UpdateLeagueCoefficient
 * @package common\models
 *
 * @property int $league_coefficient_id
 * @property int $league_coefficient_country_id
 * @property int $league_coefficient_loose
 * @property int $league_coefficient_loose_overtime
 * @property int $league_coefficient_loose_shootout
 * @property int $league_coefficient_point
 * @property int $league_coefficient_season_id
 * @property int $league_coefficient_team_id
 * @property int $league_coefficient_win
 * @property int $league_coefficient_win_overtime
 * @property int $league_coefficient_win_shootout
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
