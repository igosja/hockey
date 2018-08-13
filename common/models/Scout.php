<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Scout
 * @package common\models
 *
 * @property integer $scout_id
 * @property integer $scout_percent
 * @property integer $scout_player_id
 * @property integer $scout_ready
 * @property integer $scout_season_id
 * @property integer $scout_style
 * @property integer $scout_team_id
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
