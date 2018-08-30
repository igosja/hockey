<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class BasePhysical
 * @package common\models
 *
 * @property integer $base_physical_id
 * @property integer $base_physical_base_level
 * @property integer $base_physical_build_speed
 * @property integer $base_physical_change_count
 * @property integer $base_physical_level
 * @property integer $base_physical_price_buy
 * @property integer $base_physical_price_sell
 * @property integer $base_physical_tire_bonus
 */
class BasePhysical extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%base_physical}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'base_physical_id',
                    'base_physical_base_level',
                    'base_physical_build_speed',
                    'base_physical_change_count',
                    'base_physical_level',
                    'base_physical_price_buy',
                    'base_physical_price_sell',
                    'base_physical_tire_bonus',
                ],
                'integer'
            ],
        ];
    }
}
