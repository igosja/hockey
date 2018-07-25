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
 * @property Stadium[] $stadium
 */
class City extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%city}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['city_country_id'], 'in', 'range' => Country::find()->select(['country_id'])->column()],
            [['city_id'], 'integer'],
            [['city_country_id', 'city_name'], 'required'],
            [['city_name'], 'string', 'max' => 255],
            [['city_name'], 'trim'],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCountry(): ActiveQuery
    {
        return $this->hasOne(Country::class, ['country_id' => 'city_country_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStadium(): ActiveQuery
    {
        return $this->hasMany(Stadium::class, ['stadium_city_id' => 'stadium_id']);
    }
}
