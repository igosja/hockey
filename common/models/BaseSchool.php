<?php

namespace common\models;

/**
 * Class BaseSchool
 * @package common\models
 *
 * @property int $base_school_id
 * @property int $base_school_base_level
 * @property int $base_school_build_speed
 * @property int $base_school_level
 * @property int $base_school_player_count
 * @property int $base_school_power
 * @property int $base_school_price_buy
 * @property int $base_school_price_sell
 * @property int $base_school_school_speed
 * @property int $base_school_with_special
 * @property int $base_school_with_style
 */
class BaseSchool extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%base_school}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'base_school_id',
                    'base_school_base_level',
                    'base_school_build_speed',
                    'base_school_level',
                    'base_school_player_count',
                    'base_school_power',
                    'base_school_price_buy',
                    'base_school_price_sell',
                    'base_school_school_speed',
                    'base_school_with_special',
                    'base_school_with_style',
                ],
                'integer'
            ],
        ];
    }
}
