<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class PlayerSpecial
 * @package common\models
 *
 * @property integer $player_special_id
 * @property integer $player_special_level
 * @property integer $player_special_player_id
 * @property integer $player_special_special_id
 *
 * @property Special $special
 */
class PlayerSpecial extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%player_special}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['player_special_player_id'], 'in', 'range' => Player::find()->select(['player_id'])->column()],
            [['player_special_special_id'], 'in', 'range' => Special::find()->select(['special_id'])->column()],
            [['player_special_id', 'player_special_level'], 'integer'],
            [['player_special_level', 'player_special_player_id', 'player_special_special_id'], 'required'],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getSpecial(): ActiveQuery
    {
        return $this->hasOne(Special::class, ['special_id' => 'player_special_special_id']);
    }
}
