<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class PlayerPosition
 * @package common\models
 *
 * @property integer $player_position_id
 * @property integer $player_position_player_id
 * @property integer $player_position_position_id
 */
class PlayerPosition extends ActiveRecord
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
            [['player_position_player_id'], 'in', 'range' => Player::find()->select(['player_id'])->column()],
            [['player_position_position_id'], 'in', 'range' => Position::find()->select(['position_id'])->column()],
            [['player_position_id'], 'integer'],
            [['player_position_player_id', 'player_position_position_id'], 'required'],
        ];
    }
}
