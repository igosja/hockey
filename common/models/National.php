<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class National
 * @package common\models
 *
 * @property integer $national_id
 * @property integer $national_country_id
 * @property integer $national_finance
 * @property integer $national_mood_rest
 * @property integer $national_mood_super
 * @property integer $national_national_type_id
 * @property integer $national_power_c_16
 * @property integer $national_power_c_21
 * @property integer $national_power_c_27
 * @property integer $national_power_s_16
 * @property integer $national_power_s_21
 * @property integer $national_power_s_27
 * @property integer $national_power_v
 * @property integer $national_power_vs
 * @property integer $national_stadium_id
 * @property integer $national_user_id
 * @property integer $national_vice_id
 * @property integer $national_visitor
 */
class National extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%national}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                ['national_national_type_id'],
                'in',
                'range' => NationalType::find()->select(['national_type_id'])->column()
            ],
            [['national_country_id'], 'in', 'range' => Country::find()->select(['country_id'])->column()],
            [
                [
                    'national_id',
                    'national_finance',
                    'national_mood_rest',
                    'national_mood_super',
                    'national_power_c_16',
                    'national_power_c_21',
                    'national_power_c_27',
                    'national_power_s_16',
                    'national_power_s_21',
                    'national_power_s_27',
                    'national_power_v',
                    'national_power_vs',
                    'national_stadium_id',
                    'national_user_id',
                    'national_vice_id',
                    'national_visitor',
                ],
                'integer'
            ],
        ];
    }
}
