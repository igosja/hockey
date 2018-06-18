<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Base
 * @package common\models
 *
 * @property integer $base_id
 * @property integer base_build_speed
 * @property integer base_level
 * @property integer base_maintenance_base
 * @property integer base_maintenance_slot
 * @property integer base_price_buy
 * @property integer base_price_sell
 * @property integer base_slot_max
 * @property integer base_slot_min
 */
class Base extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%base}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'base_id',
                    'base_build_speed',
                    'base_level',
                    'base_maintenance_base',
                    'base_maintenance_slot',
                    'base_price_buy',
                    'base_price_sell',
                    'base_slot_max',
                    'base_slot_min',
                ],
                'integer'
            ],
        ];
    }
}
