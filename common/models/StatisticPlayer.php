<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class StatisticPlayer
 * @package common\models
 *
 * @property integer $statistic_player_id
 * @property integer $statistic_player_assist
 * @property integer $statistic_player_assist_power
 * @property integer $statistic_player_assist_short
 * @property integer $statistic_player_bullet_win
 * @property integer $statistic_player_championship_playoff
 * @property integer $statistic_player_country_id
 * @property integer $statistic_player_division_id
 * @property integer $statistic_player_face_off
 * @property integer $statistic_player_face_off_percent
 * @property integer $statistic_player_face_off_win
 * @property integer $statistic_player_game
 * @property integer $statistic_player_game_with_bullet
 * @property integer $statistic_player_is_gk
 * @property integer $statistic_player_loose
 * @property integer $statistic_player_national_id
 * @property integer $statistic_player_pass
 * @property integer $statistic_player_pass_per_game
 * @property integer $statistic_player_penalty
 * @property integer $statistic_player_player_id
 * @property integer $statistic_player_plus_minus
 * @property integer $statistic_player_point
 * @property integer $statistic_player_save
 * @property integer $statistic_player_save_percent
 * @property integer $statistic_player_score
 * @property integer $statistic_player_score_draw
 * @property integer $statistic_player_score_power
 * @property integer $statistic_player_score_short
 * @property integer $statistic_player_score_shot_percent
 * @property integer $statistic_player_score_win
 * @property integer $statistic_player_season_id
 * @property integer $statistic_player_shot
 * @property integer $statistic_player_shot_gk
 * @property integer $statistic_player_shot_per_game
 * @property integer $statistic_player_shutout
 * @property integer $statistic_player_team_id
 * @property integer $statistic_player_tournament_type_id
 * @property integer $statistic_player_win
 */
class StatisticPlayer extends ActiveRecord
{
    const AGE_READY_FOR_PENSION = 39;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%statistic_player}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'statistic_player_id',
                    'statistic_player_assist',
                    'statistic_player_assist_power',
                    'statistic_player_assist_short',
                    'statistic_player_bullet_win',
                    'statistic_player_championship_playoff',
                    'statistic_player_country_id',
                    'statistic_player_division_id',
                    'statistic_player_face_off',
                    'statistic_player_face_off_percent',
                    'statistic_player_face_off_win',
                    'statistic_player_game',
                    'statistic_player_game_with_bullet',
                    'statistic_player_is_gk',
                    'statistic_player_loose',
                    'statistic_player_national_id',
                    'statistic_player_pass',
                    'statistic_player_pass_per_game',
                    'statistic_player_penalty',
                    'statistic_player_player_id',
                    'statistic_player_plus_minus',
                    'statistic_player_point',
                    'statistic_player_save',
                    'statistic_player_save_percent',
                    'statistic_player_score',
                    'statistic_player_score_draw',
                    'statistic_player_score_power',
                    'statistic_player_score_short',
                    'statistic_player_score_shot_percent',
                    'statistic_player_score_win',
                    'statistic_player_season_id',
                    'statistic_player_shot',
                    'statistic_player_shot_gk',
                    'statistic_player_shot_per_game',
                    'statistic_player_shutout',
                    'statistic_player_team_id',
                    'statistic_player_tournament_type_id',
                    'statistic_player_win',
                ],
                'integer'
            ],
            [['statistic_player_player_id'], 'required'],
        ];
    }
}