<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class City
 * @package common\models
 *
 * @property integer $city_id
 * @property integer $city_country_id
 * @property string $city_name
 *
 * @property Country $country
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
            [['city_country_id'], 'in', 'range' => Country::find()->select(['country_id'])->column()],
            [['city_id'], 'integer'],
            [['city_country_id', 'city_name'], 'required'],
            [['city_name'], 'string', 'max' => 255],
            [['city_name'], 'trim'],
        ];
    }

    public function getCountry(): ActiveQuery
    {
        return $this->hasOne(Country::class, ['country_id' => 'city_country_id']);
    }
}
