<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Game
 * @package common\models
 *
 * @property integer $game_id
 * @property integer $game_bonus_home
 * @property integer $game_guest_auto
 * @property integer $game_guest_collision_1
 * @property integer $game_guest_collision_2
 * @property integer $game_guest_collision_3
 * @property integer $game_guest_forecast
 * @property integer $game_guest_mood_id
 * @property integer $game_guest_national_id
 * @property integer $game_guest_optimality_1
 * @property integer $game_guest_optimality_2
 * @property integer $game_guest_penalty
 * @property integer $game_guest_penalty_1
 * @property integer $game_guest_penalty_2
 * @property integer $game_guest_penalty_3
 * @property integer $game_guest_penalty_overtime
 * @property integer $game_guest_plus_minus
 * @property float $game_guest_plus_minus_competition
 * @property float $game_guest_plus_minus_mood
 * @property float $game_guest_plus_minus_optimality_1
 * @property float $game_guest_plus_minus_optimality_2
 * @property float $game_guest_plus_minus_power
 * @property float $game_guest_plus_minus_score
 * @property integer $game_guest_power
 * @property integer $game_guest_power_percent
 * @property integer $game_guest_rude_1_id
 * @property integer $game_guest_rude_2_id
 * @property integer $game_guest_rude_3_id
 * @property integer $game_guest_score
 * @property integer $game_guest_score_1
 * @property integer $game_guest_score_2
 * @property integer $game_guest_score_3
 * @property integer $game_guest_score_overtime
 * @property integer $game_guest_score_shootout
 * @property integer $game_guest_shot
 * @property integer $game_guest_shot_1
 * @property integer $game_guest_shot_2
 * @property integer $game_guest_shot_3
 * @property integer $game_guest_shot_overtime
 * @property integer $game_guest_style_1_id
 * @property integer $game_guest_style_2_id
 * @property integer $game_guest_style_3_id
 * @property integer $game_guest_tactic_1_id
 * @property integer $game_guest_tactic_2_id
 * @property integer $game_guest_tactic_3_id
 * @property integer $game_guest_team_id
 * @property float $game_guest_teamwork_1
 * @property float $game_guest_teamwork_2
 * @property float $game_guest_teamwork_3
 * @property integer $game_home_auto
 * @property integer $game_home_collision_1
 * @property integer $game_home_collision_2
 * @property integer $game_home_collision_3
 * @property integer $game_home_forecast
 * @property integer $game_home_mood_id
 * @property integer $game_home_national_id
 * @property integer $game_home_optimality_1
 * @property integer $game_home_optimality_2
 * @property integer $game_home_penalty
 * @property integer $game_home_penalty_1
 * @property integer $game_home_penalty_2
 * @property integer $game_home_penalty_3
 * @property integer $game_home_penalty_overtime
 * @property integer $game_home_plus_minus
 * @property float $game_home_plus_minus_competition
 * @property float $game_home_plus_minus_mood
 * @property float $game_home_plus_minus_optimality_1
 * @property float $game_home_plus_minus_optimality_2
 * @property float $game_home_plus_minus_power
 * @property float $game_home_plus_minus_score
 * @property integer $game_home_power
 * @property integer $game_home_power_percent
 * @property integer $game_home_rude_1_id
 * @property integer $game_home_rude_2_id
 * @property integer $game_home_rude_3_id
 * @property integer $game_home_score
 * @property integer $game_home_score_1
 * @property integer $game_home_score_2
 * @property integer $game_home_score_3
 * @property integer $game_home_score_overtime
 * @property integer $game_home_score_shootout
 * @property integer $game_home_shot
 * @property integer $game_home_shot_1
 * @property integer $game_home_shot_2
 * @property integer $game_home_shot_3
 * @property integer $game_home_shot_overtime
 * @property integer $game_home_style_1_id
 * @property integer $game_home_style_2_id
 * @property integer $game_home_style_3_id
 * @property integer $game_home_tactic_1_id
 * @property integer $game_home_tactic_2_id
 * @property integer $game_home_tactic_3_id
 * @property integer $game_home_team_id
 * @property float $game_home_teamwork_1
 * @property float $game_home_teamwork_2
 * @property float $game_home_teamwork_3
 * @property integer $game_played
 * @property integer $game_ticket
 * @property integer $game_schedule_id
 * @property integer $game_stadium_capacity
 * @property integer $game_stadium_id
 * @property integer $game_visitor
 */
class Game extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%game}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['game_schedule_id'], 'in', 'range' => Schedule::find()->select(['schedule_id'])->column()],
            [['game_guest_team_id', 'game_home_team_id'], 'in', 'range' => Team::find()->select(['team_id'])->column()],
            [['game_stadium_id'], 'in', 'range' => Stadium::find()->select(['stadium_id'])->column()],
            [
                [
                    'game_id',
                    'game_bonus_home',
                    'game_guest_auto',
                    'game_guest_collision_1',
                    'game_guest_collision_2',
                    'game_guest_collision_3',
                    'game_guest_forecast',
                    'game_guest_mood_id',
                    'game_guest_national_id',
                    'game_guest_optimality_1',
                    'game_guest_optimality_2',
                    'game_guest_penalty',
                    'game_guest_penalty_1',
                    'game_guest_penalty_2',
                    'game_guest_penalty_3',
                    'game_guest_penalty_overtime',
                    'game_guest_plus_minus',
                    'game_guest_power',
                    'game_guest_power_percent',
                    'game_guest_rude_1_id',
                    'game_guest_rude_2_id',
                    'game_guest_rude_3_id',
                    'game_guest_score',
                    'game_guest_score_1',
                    'game_guest_score_2',
                    'game_guest_score_3',
                    'game_guest_score_overtime',
                    'game_guest_score_shootout',
                    'game_guest_shot',
                    'game_guest_shot_1',
                    'game_guest_shot_2',
                    'game_guest_shot_3',
                    'game_guest_shot_overtime',
                    'game_guest_style_1_id',
                    'game_guest_style_2_id',
                    'game_guest_style_3_id',
                    'game_guest_tactic_1_id',
                    'game_guest_tactic_2_id',
                    'game_guest_tactic_3_id',
                    'game_home_auto',
                    'game_home_collision_1',
                    'game_home_collision_2',
                    'game_home_collision_3',
                    'game_home_forecast',
                    'game_home_mood_id',
                    'game_home_national_id',
                    'game_home_optimality_1',
                    'game_home_optimality_2',
                    'game_home_penalty',
                    'game_home_penalty_1',
                    'game_home_penalty_2',
                    'game_home_penalty_3',
                    'game_home_penalty_overtime',
                    'game_home_plus_minus',
                    'game_home_power',
                    'game_home_power_percent',
                    'game_home_rude_1_id',
                    'game_home_rude_2_id',
                    'game_home_rude_3_id',
                    'game_home_score',
                    'game_home_score_1',
                    'game_home_score_2',
                    'game_home_score_3',
                    'game_home_score_overtime',
                    'game_home_score_shootout',
                    'game_home_shot',
                    'game_home_shot_1',
                    'game_home_shot_2',
                    'game_home_shot_3',
                    'game_home_shot_overtime',
                    'game_home_style_1_id',
                    'game_home_style_2_id',
                    'game_home_style_3_id',
                    'game_home_tactic_1_id',
                    'game_home_tactic_2_id',
                    'game_home_tactic_3_id',
                    'game_played',
                    'game_ticket',
                    'game_stadium_capacity',
                    'game_visitor',
                ],
                'integer'
            ],
            [
                [
                    'game_guest_plus_minus_competition',
                    'game_guest_plus_minus_mood',
                    'game_guest_plus_minus_optimality_1',
                    'game_guest_plus_minus_optimality_2',
                    'game_guest_plus_minus_power',
                    'game_guest_plus_minus_score',
                    'game_guest_teamwork_1',
                    'game_guest_teamwork_2',
                    'game_guest_teamwork_3',
                    'game_home_plus_minus_competition',
                    'game_home_plus_minus_mood',
                    'game_home_plus_minus_optimality_1',
                    'game_home_plus_minus_optimality_2',
                    'game_home_plus_minus_power',
                    'game_home_plus_minus_score',
                    'game_home_teamwork_1',
                    'game_home_teamwork_2',
                    'game_home_teamwork_3',
                ],
                'number'
            ],
            [['game_schedule_id'], 'required'],
        ];
    }
}
