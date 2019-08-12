<?php

namespace common\models;

/**
 * Class BasePhysical
 * @package common\models
 *
 * @property int $base_physical_id
 * @property int $base_physical_base_level
 * @property int $base_physical_build_speed
 * @property int $base_physical_change_count
 * @property int $base_physical_level
 * @property int $base_physical_price_buy
 * @property int $base_physical_price_sell
 * @property int $base_physical_tire_bonus
 */
class BasePhysical extends AbstractActiveRecord
{
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
