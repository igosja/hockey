<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Country
 * @package common\models
 *
 * @property integer $country_id
 * @property integer $country_auto
 * @property integer $country_finance
 * @property integer $country_game
 * @property string $country_name
 * @property integer $country_president_id
 * @property integer $country_president_vice_id
 * @property integer $country_stadium_capacity
 */
class Country extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%country}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'country_id',
                    'country_auto',
                    'country_finance',
                    'country_game',
                    'country_president_id',
                    'country_president_vice_id',
                    'country_stadium_capacity'
                ],
                'integer'
            ],
            [['country_name'], 'required'],
            [['country_name'], 'string', 'max' => 255],
            [['country_name'], 'trim'],
            [['country_name'], 'unique'],
        ];
    }
}
