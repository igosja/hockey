<?php

namespace common\models;

/**
 * Class Planning
 * @package common\models
 *
 * @property int $planning_id
 * @property int $planning_player_id
 * @property int $planning_season_id
 * @property int $planning_schedule_id
 * @property int $planning_team_id
 */
class Planning extends AbstractActiveRecord
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'planning_id',
                    'planning_player_id',
                    'planning_season_id',
                    'planning_schedule_id',
                    'planning_team_id',
                ],
                'integer'
            ],
        ];
    }
}
