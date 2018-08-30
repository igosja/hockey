<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Lineup
 * @package common\models
 *
 * @property integer $lineup_id
 * @property integer $lineup_age
 * @property integer $lineup_assist
 * @property integer $lineup_game_id
 * @property integer $lineup_line_id
 * @property integer $lineup_national_id
 * @property integer $lineup_pass
 * @property integer $lineup_penalty
 * @property integer $lineup_player_id
 * @property integer $lineup_plus_minus
 * @property integer $lineup_position_id
 * @property integer $lineup_power_change
 * @property integer $lineup_power_nominal
 * @property integer $lineup_power_real
 * @property integer $lineup_score
 * @property integer $lineup_shot
 * @property integer $lineup_team_id
 *
 * @property Game $game
 * @property Position $position
 */
class Lineup extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%lineup}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'lineup_id',
                    'lineup_age',
                    'lineup_assist',
                    'lineup_game_id',
                    'lineup_line_id',
                    'lineup_national_id',
                    'lineup_pass',
                    'lineup_penalty',
                    'lineup_player_id',
                    'lineup_plus_minus',
                    'lineup_position_id',
                    'lineup_power_change',
                    'lineup_power_nominal',
                    'lineup_power_real',
                    'lineup_score',
                    'lineup_shot',
                    'lineup_team_id',
                ],
                'integer'
            ],
        ];
    }

    /**
     * @return string
     */
    public function iconPowerChange(): string
    {
        $result = '';
        if ($this->lineup_power_change > 0) {
            $result = '<i class="fa fa-plus-square-o"></i>';
        } elseif ($this->lineup_power_change < 0) {
            $result = '<i class="fa fa-minus-square-o"></i>';
        }
        return $result;
    }

    /**
     * @return ActiveQuery
     */
    public function getGame(): ActiveQuery
    {
        return $this->hasOne(Game::class, ['game_id' => 'lineup_game_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPosition(): ActiveQuery
    {
        return $this->hasOne(Position::class, ['position_id' => 'lineup_position_id']);
    }
}
