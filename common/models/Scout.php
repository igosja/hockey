<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class Scout
 * @package common\models
 *
 * @property int $scout_id
 * @property int $scout_is_school
 * @property int $scout_percent
 * @property int $scout_player_id
 * @property int $scout_ready
 * @property int $scout_season_id
 * @property int $scout_style
 * @property int $scout_team_id
 *
 * @property Player $player
 */
class Scout extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%scout}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'scout_id',
                    'scout_is_school',
                    'scout_percent',
                    'scout_player_id',
                    'scout_ready',
                    'scout_season_id',
                    'scout_style',
                    'scout_team_id',
                ],
                'integer'
            ],
            [['scout_player_id', 'scout_team_id'], 'required'],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getPlayer(): ActiveQuery
    {
        return $this->hasOne(Player::class, ['player_id' => 'scout_player_id'])->cache();
    }
}
