<?php

namespace common\models;

/**
 * Class Teamwork
 * @package common\models
 *
 * @property int $teamwork_id
 * @property int $teamwork_player_id_1
 * @property int $teamwork_player_id_2
 * @property int $teamwork_value
 */
class Teamwork extends AbstractActiveRecord
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'teamwork_id',
                    'teamwork_player_id_1',
                    'teamwork_player_id_2',
                    'teamwork_value',
                ],
                'integer'
            ],
        ];
    }
}
