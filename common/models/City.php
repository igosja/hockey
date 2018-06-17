<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class City
 * @package common\models
 *
 * @property integer $city_id
 * @property integer $city_country_id
 * @property string $city_name
 */
class City extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%city}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['city_id', 'city_country_id'], 'integer'],
            [['city_country_id', 'city_name'], 'required'],
            [['city_name'], 'string', 'max' => 255],
            [['city_name'], 'trim'],
        ];
    }
}
