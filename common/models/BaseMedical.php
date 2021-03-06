<?php

namespace common\models;

/**
 * Class BaseMedical
 * @package common\models
 *
 * @property int $base_medical_id
 * @property int $base_medical_base_level
 * @property int $base_medical_build_speed
 * @property int $base_medical_level
 * @property int $base_medical_price_buy
 * @property int $base_medical_price_sell
 * @property int $base_medical_tire
 */
class BaseMedical extends AbstractActiveRecord
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'base_medical_id',
                    'base_medical_base_level',
                    'base_medical_build_speed',
                    'base_medical_level',
                    'base_medical_price_buy',
                    'base_medical_price_sell',
                    'base_medical_tire',
                ],
                'integer'
            ],
        ];
    }
}
