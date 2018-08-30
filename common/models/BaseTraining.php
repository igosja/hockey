<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class BaseTraining
 * @package common\models
 *
 * @property integer $base_training_id
 * @property integer $base_training_base_level
 * @property integer $base_training_build_speed
 * @property integer $base_training_level
 * @property integer $base_training_position_count
 * @property integer $base_training_position_price
 * @property integer $base_training_power_count
 * @property integer $base_training_power_price
 * @property integer $base_training_price_buy
 * @property integer $base_training_price_sell
 * @property integer $base_training_special_count
 * @property integer $base_training_special_price
 * @property integer $base_training_training_speed_max
 * @property integer $base_training_training_speed_min
 */
class BaseTraining extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%base_training}}';
    }

    /**
     * @return array
     */
    public function rules(): array
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
