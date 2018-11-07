<?php

namespace common\models;

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
 */
class Training extends AbstractActiveRecord
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
