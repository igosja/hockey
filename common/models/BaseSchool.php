<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class BaseSchool
 * @package common\models
 *
 * @property integer $base_school_id
 * @property integer $base_school_base_level
 * @property integer $base_school_build_speed
 * @property integer $base_school_level
 * @property integer $base_school_player_count
 * @property integer $base_school_power
 * @property integer $base_school_price_buy
 * @property integer $base_school_price_sell
 * @property integer $base_school_school_speed
 * @property integer $base_school_with_special
 * @property integer $base_school_with_style
 */
class BaseSchool extends ActiveRecord
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
