<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Training
 * @package common\models
 *
 * @property integer $training_id
 * @property integer $training_percent
 * @property integer $training_player_id
 * @property integer $training_position_id
 * @property integer $training_power
 * @property integer $training_ready
 * @property integer $training_season_id
 * @property integer $training_special_id
 * @property integer $training_team_id
 */
class Training extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%training}}';
    }

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
}
