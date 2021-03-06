<?php

namespace common\models;

/**
 * Class NationalPlayerDay
 * @package common\models
 *
 * @property int $national_player_day_id
 * @property int $national_player_day_day
 * @property int $national_player_day_national_id
 * @property int $national_player_day_player_id
 * @property int $national_player_day_team_id
 */
class NationalPlayerDay extends AbstractActiveRecord
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'national_player_day_id',
                    'national_player_day_day',
                    'national_player_day_national_id',
                    'national_player_day_player_id',
                    'national_player_day_team_id',
                ],
                'integer'
            ],
        ];
    }
}
