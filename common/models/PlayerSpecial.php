<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class PlayerSpecial
 * @package common\models
 *
 * @property int $player_special_id
 * @property int $player_special_level
 * @property int $player_special_player_id
 * @property int $player_special_special_id
 *
 * @property Lineup[] $lineup
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
            [
                ['player_special_id', 'player_special_level', 'player_special_player_id', 'player_special_special_id'],
                'integer'
            ],
            [['player_special_level', 'player_special_player_id', 'player_special_special_id'], 'required'],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getLineup(): ActiveQuery
    {
        return $this->hasMany(Lineup::class, ['lineup_player_id' => 'player_special_player_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSpecial(): ActiveQuery
    {
        return $this->hasOne(Special::class, ['special_id' => 'player_special_special_id']);
    }
}
