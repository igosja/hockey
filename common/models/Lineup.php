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
 * @property int $lineup_captain
 * @property int $lineup_game_id
 * @property int $lineup_line_id
 * @property int $lineup_national_id
 * @property int $lineup_pass
 * @property int $lineup_penalty
 * @property int $lineup_player_id
 * @property int $lineup_plus_minus
 * @property int $lineup_position_id
 * @property int $lineup_power_change
 * @property int $lineup_power_nominal
 * @property int $lineup_power_real
 * @property int $lineup_score
 * @property int $lineup_shot
 * @property int $lineup_team_id
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
    public static function tableName()
    {
        return '{{%lineup}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'lineup_id',
                    'lineup_age',
                    'lineup_assist',
                    'lineup_captain',
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

    public function iconCaptain()
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
    public function iconPowerChange()
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
    public function special()
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
    public function getGame()
    {
        return $this->hasOne(Game::class, ['game_id' => 'lineup_game_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPlayerSpecial()
    {
        return $this->hasMany(LineupSpecial::class, ['lineup_special_lineup_id' => 'lineup_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPlayer()
    {
        return $this->hasOne(Player::class, ['player_id' => 'lineup_player_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPosition()
    {
        return $this->hasOne(Position::class, ['position_id' => 'lineup_position_id']);
    }
}
