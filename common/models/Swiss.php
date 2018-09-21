<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Swiss
 * @package common\models
 *
 * @property int $swiss_id
 * @property int $swiss_guest
 * @property int $swiss_home
 * @property int $swiss_place
 * @property int $swiss_team_id
 */
class Swiss extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%swiss}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['swiss_id', 'swiss_guest', 'swiss_home', 'swiss_place', 'swiss_team_id'], 'integer'],
        ];
    }
}
