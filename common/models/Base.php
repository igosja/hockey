<?php

namespace common\models;

/**
 * Class Base
 * @package common\models
 *
 * @property int $base_id
 * @property int $base_build_speed
 * @property int $base_level
 * @property int $base_maintenance_base
 * @property int $base_maintenance_slot
 * @property int $base_price_buy
 * @property int $base_price_sell
 * @property int $base_slot_max
 * @property int $base_slot_min
 */
class Base extends AbstractActiveRecord
{
    /**
     * @return array
     */
    public function rules(): array
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
