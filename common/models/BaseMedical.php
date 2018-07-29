<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class BaseMedical
 * @package common\models
 *
 * @property integer $base_medical_id
 * @property integer $base_medical_base_level
 * @property integer $base_medical_build_speed
 * @property integer $base_medical_level
 * @property integer $base_medical_price_buy
 * @property integer $base_medical_price_sell
 * @property integer $base_medical_tire
 */
class BaseMedical extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%base_medical}}';
    }

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
