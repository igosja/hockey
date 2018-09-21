<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class PhysicalChange
 * @package common\models
 *
 * @property int $physical_change_id
 * @property int $physical_change_player_id
 * @property int $physical_change_season_id
 * @property int $physical_change_schedule_id
 * @property int $physical_change_team_id
 */
class PhysicalChange extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%physical_change}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'physical_change_id',
                    'physical_change_player_id',
                    'physical_change_season_id',
                    'physical_change_schedule_id',
                    'physical_change_team_id',
                ],
                'integer'
            ],
        ];
    }
}
