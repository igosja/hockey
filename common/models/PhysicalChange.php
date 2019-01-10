<?php

namespace common\models;

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
class PhysicalChange extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%physical_change}}';
    }

    /**
     * @return array
     */
    public function rules()
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
