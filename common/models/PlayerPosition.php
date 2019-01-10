<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class PlayerPosition
 * @package common\models
 *
 * @property int $player_position_player_id
 * @property int $player_position_position_id
 *
 * @property Position $position
 */
class PlayerPosition extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%player_position}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['player_position_player_id', 'player_position_position_id'], 'integer'],
            [['player_position_player_id', 'player_position_position_id'], 'required'],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getPosition()
    {
        return $this->hasOne(Position::class, ['position_id' => 'player_position_position_id']);
    }
}
