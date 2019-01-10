<?php

namespace common\models;

/**
 * Class BaseTraining
 * @package common\models
 *
 * @property int $base_training_id
 * @property int $base_training_base_level
 * @property int $base_training_build_speed
 * @property int $base_training_level
 * @property int $base_training_position_count
 * @property int $base_training_position_price
 * @property int $base_training_power_count
 * @property int $base_training_power_price
 * @property int $base_training_price_buy
 * @property int $base_training_price_sell
 * @property int $base_training_special_count
 * @property int $base_training_special_price
 * @property int $base_training_training_speed_max
 * @property int $base_training_training_speed_min
 */
class BaseTraining extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%base_training}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'base_training_id',
                    'base_training_base_level',
                    'base_training_build_speed',
                    'base_training_level',
                    'base_training_position_count',
                    'base_training_position_price',
                    'base_training_power_count',
                    'base_training_power_price',
                    'base_training_price_buy',
                    'base_training_price_sell',
                    'base_training_special_count',
                    'base_training_special_price',
                    'base_training_training_speed_max',
                    'base_training_training_speed_min',
                ],
                'integer'
            ],
        ];
    }
}
