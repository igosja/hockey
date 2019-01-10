<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class StatisticPlayer
 * @package common\models
 *
 * @property int $statistic_player_id
 * @property int $statistic_player_assist
 * @property int $statistic_player_assist_power
 * @property int $statistic_player_assist_short
 * @property int $statistic_player_shootout_win
 * @property int $statistic_player_championship_playoff
 * @property int $statistic_player_country_id
 * @property int $statistic_player_division_id
 * @property int $statistic_player_face_off
 * @property int $statistic_player_face_off_percent
 * @property int $statistic_player_face_off_win
 * @property int $statistic_player_game
 * @property int $statistic_player_game_with_shootout
 * @property int $statistic_player_is_gk
 * @property int $statistic_player_loose
 * @property int $statistic_player_national_id
 * @property int $statistic_player_pass
 * @property int $statistic_player_pass_per_game
 * @property int $statistic_player_penalty
 * @property int $statistic_player_player_id
 * @property int $statistic_player_plus_minus
 * @property int $statistic_player_point
 * @property int $statistic_player_save
 * @property int $statistic_player_save_percent
 * @property int $statistic_player_score
 * @property int $statistic_player_score_draw
 * @property int $statistic_player_score_power
 * @property int $statistic_player_score_short
 * @property int $statistic_player_score_shot_percent
 * @property int $statistic_player_score_win
 * @property int $statistic_player_season_id
 * @property int $statistic_player_shot
 * @property int $statistic_player_shot_gk
 * @property int $statistic_player_shot_per_game
 * @property int $statistic_player_shutout
 * @property int $statistic_player_team_id
 * @property int $statistic_player_tournament_type_id
 * @property int $statistic_player_win
 *
 * @property Player $player
 * @property Team $team
 */
class StatisticPlayer extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%statistic_player}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'statistic_player_id',
                    'statistic_player_assist',
                    'statistic_player_assist_power',
                    'statistic_player_assist_short',
                    'statistic_player_shootout_win',
                    'statistic_player_championship_playoff',
                    'statistic_player_country_id',
                    'statistic_player_division_id',
                    'statistic_player_face_off',
                    'statistic_player_face_off_win',
                    'statistic_player_game',
                    'statistic_player_game_with_shootout',
                    'statistic_player_is_gk',
                    'statistic_player_loose',
                    'statistic_player_national_id',
                    'statistic_player_pass',
                    'statistic_player_penalty',
                    'statistic_player_player_id',
                    'statistic_player_plus_minus',
                    'statistic_player_point',
                    'statistic_player_save',
                    'statistic_player_score',
                    'statistic_player_score_draw',
                    'statistic_player_score_power',
                    'statistic_player_score_short',
                    'statistic_player_score_win',
                    'statistic_player_season_id',
                    'statistic_player_shot',
                    'statistic_player_shot_gk',
                    'statistic_player_shutout',
                    'statistic_player_team_id',
                    'statistic_player_tournament_type_id',
                    'statistic_player_win',
                ],
                'integer'
            ],
            [
                [
                    'statistic_player_face_off_percent',
                    'statistic_player_pass_per_game',
                    'statistic_player_save_percent',
                    'statistic_player_score_shot_percent',
                    'statistic_player_shot_per_game',
                ],
                'number'
            ],
            [['statistic_player_player_id'], 'required'],
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->statistic_player_season_id = Season::getCurrentSeason();
            }
            return true;
        }
        return false;
    }

    /**
     * @return ActiveQuery
     */
    public function getPlayer()
    {
        return $this->hasOne(Player::class, ['player_id' => 'statistic_player_player_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasOne(Team::class, ['team_id' => 'statistic_player_team_id']);
    }
}
