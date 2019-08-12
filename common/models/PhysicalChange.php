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
