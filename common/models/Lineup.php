<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class Lineup
 * @package common\models
 *
 * @property int $lineup_id
 * @property int $lineup_age
 * @property int $lineup_assist
 * @property int $lineup_assist_power
 * @property int $lineup_assist_short
 * @property int $lineup_captain
 * @property int $lineup_face_off
 * @property int $lineup_face_off_win
 * @property int $lineup_game_id
 * @property int $lineup_game_with_shootout
 * @property int $lineup_line_id
 * @property int $lineup_loose
 * @property int $lineup_national_id
 * @property int $lineup_pass
 * @property int $lineup_penalty
 * @property int $lineup_player_id
 * @property int $lineup_plus_minus
 * @property int $lineup_point
 * @property int $lineup_position_id
 * @property int $lineup_power_change
 * @property int $lineup_power_nominal
 * @property int $lineup_power_real
 * @property int $lineup_save
 * @property int $lineup_score
 * @property int $lineup_score_draw
 * @property int $lineup_score_power
 * @property int $lineup_score_short
 * @property int $lineup_score_win
 * @property int $lineup_shot
 * @property int $lineup_shootout_win
 * @property int $lineup_shutout
 * @property int $lineup_team_id
 * @property int $lineup_win
 *
 * @property Game $game
 * @property LineupSpecial[] $playerSpecial
 * @property Player $player
 * @property Position $position
 */
class Lineup extends AbstractActiveRecord
{
    const GAME_QUANTITY = 22;

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
                    'lineup_assist_power',
                    'lineup_assist_short',
                    'lineup_captain',
                    'lineup_face_off',
                    'lineup_face_off_win',
                    'lineup_game_id',
                    'lineup_game_with_shootout',
                    'lineup_line_id',
                    'lineup_loose',
                    'lineup_national_id',
                    'lineup_pass',
                    'lineup_penalty',
                    'lineup_player_id',
                    'lineup_plus_minus',
                    'lineup_point',
                    'lineup_position_id',
                    'lineup_power_change',
                    'lineup_power_nominal',
                    'lineup_power_real',
                    'lineup_save',
                    'lineup_score',
                    'lineup_score_draw',
                    'lineup_score_power',
                    'lineup_score_short',
                    'lineup_score_win',
                    'lineup_shot',
                    'lineup_shootout_win',
                    'lineup_shutout',
                    'lineup_team_id',
                    'lineup_win',
                ],
                'integer'
            ],
        ];
    }

    public function iconCaptain(): string
    {
        $result = '';
        if ($this->lineup_captain) {
            $result = '<i class="fa fa-copyright" title="Капитан"></i>';
        }
        return $result;
    }

    /**
     * @return string
     */
    public function iconPowerChange(): string
    {
        $result = '';
        if ($this->lineup_power_change > 0) {
            $result = '<i class="fa fa-plus-square-o" title="+1 балл по результатам матча"></i>';
        } elseif ($this->lineup_power_change < 0) {
            $result = '<i class="fa fa-minus-square-o" title="-1 балл по результатам матча"></i>';
        }
        return $result;
    }

    /**
     * @return string
     */
    public function special(): string
    {
        $result = [];
        foreach ($this->playerSpecial as $special) {
            $result[] = $special->special->special_name . $special->lineup_special_level;
        }
        return implode(' ', $result);
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
    public function getPlayerSpecial(): ActiveQuery
    {
        return $this->hasMany(LineupSpecial::class, ['lineup_special_lineup_id' => 'lineup_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPlayer(): ActiveQuery
    {
        return $this->hasOne(Player::class, ['player_id' => 'lineup_player_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPosition(): ActiveQuery
    {
        return $this->hasOne(Position::class, ['position_id' => 'lineup_position_id']);
    }
}
