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
     * @return string
     */
    public static function tableName()
    {
        return '{{%teamwork}}';
    }

    /**
     * @return array
     */
    public function rules()
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
