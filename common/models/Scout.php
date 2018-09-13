<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Scout
 * @package common\models
 *
 * @property int $scout_id
 * @property int $scout_percent
 * @property int $scout_player_id
 * @property int $scout_ready
 * @property int $scout_season_id
 * @property int $scout_style
 * @property int $scout_team_id
 */
class Scout extends ActiveRecord
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
}
