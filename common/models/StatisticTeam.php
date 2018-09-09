<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class StatisticTeam
 * @package common\models
 *
 * @property integer $statistic_team_id
 * @property integer $statistic_team_championship_playoff
 * @property integer $statistic_team_country_id
 * @property integer $statistic_team_division_id
 * @property integer $statistic_team_game
 * @property integer $statistic_team_game_no_pass
 * @property integer $statistic_team_game_no_score
 * @property integer $statistic_team_loose
 * @property integer $statistic_team_loose_over
 * @property integer $statistic_team_loose_shootout
 * @property integer $statistic_team_national_id
 * @property integer $statistic_team_pass
 * @property integer $statistic_team_penalty_minute
 * @property integer $statistic_team_penalty_minute_opponent
 * @property integer $statistic_team_score
 * @property integer $statistic_team_season_id
 * @property integer $statistic_team_team_id
 * @property integer $statistic_team_tournament_type_id
 * @property integer $statistic_team_win
 * @property integer $statistic_team_win_over
 * @property float $statistic_team_win_percent
 * @property integer $statistic_team_win_shootout
 */
class StatisticTeam extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%statistic_team}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'statistic_team_id',
                    'statistic_team_championship_playoff',
                    'statistic_team_country_id',
                    'statistic_team_division_id',
                    'statistic_team_game',
                    'statistic_team_game_no_pass',
                    'statistic_team_game_no_score',
                    'statistic_team_loose',
                    'statistic_team_loose_over',
                    'statistic_team_loose_shootout',
                    'statistic_team_national_id',
                    'statistic_team_pass',
                    'statistic_team_penalty_minute',
                    'statistic_team_penalty_minute_opponent',
                    'statistic_team_score',
                    'statistic_team_season_id',
                    'statistic_team_team_id',
                    'statistic_team_tournament_type_id',
                    'statistic_team_win',
                    'statistic_team_win_over',
                    'statistic_team_win_shootout',
                ],
                'integer'
            ],
            [['statistic_team_win_percent'], 'number'],
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
                if (!$this->statistic_team_season_id) {
                    $this->statistic_team_season_id = Season::getCurrentSeason();
                }
            }
            return true;
        }
        return false;
    }
}
