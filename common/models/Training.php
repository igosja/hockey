<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class Training
 * @package common\models
 *
 * @property int $training_id
 * @property int $training_percent
 * @property int $training_player_id
 * @property int $training_position_id
 * @property int $training_power
 * @property int $training_ready
 * @property int $training_season_id
 * @property int $training_special_id
 * @property int $training_team_id
 *
 * @property Player $player
 * @property Position $position
 * @property Special $special
 */
class Training extends AbstractActiveRecord
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'training_id',
                    'training_percent',
                    'training_player_id',
                    'training_position_id',
                    'training_power',
                    'training_ready',
                    'training_season_id',
                    'training_special_id',
                    'training_team_id',
                ],
                'integer'
            ],
            [['training_player_id', 'training_team_id'], 'required'],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getPlayer(): ActiveQuery
    {
        return $this->hasOne(Player::class, ['player_id' => 'training_player_id'])->cache();
    }

    /**
     * @return ActiveQuery
     */
    public function getPosition(): ActiveQuery
    {
        return $this->hasOne(Position::class, ['position_id' => 'training_position_id'])->cache();
    }

    /**
     * @return ActiveQuery
     */
    public function getSpecial(): ActiveQuery
    {
        return $this->hasOne(Special::class, ['special_id' => 'training_special_id'])->cache();
    }
}
