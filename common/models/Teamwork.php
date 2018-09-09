<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Teamwork
 * @package common\models
 *
 * @property integer $teamwork_id
 * @property integer $teamwork_player_id_1
 * @property integer $teamwork_player_id_2
 * @property integer $teamwork_value
 */
class Teamwork extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%teamwork}}';
    }

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
