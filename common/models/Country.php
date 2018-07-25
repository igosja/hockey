<?php

namespace common\models;

use yii\db\ActiveQuery;
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
 *
 * @property City[] $city
 */
class Country extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%country}}';
    }

    /**
     * @return array
     */
    public function rules(): array
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

    /**
     * @return ActiveQuery
     */
    public function getCity(): ActiveQuery
    {
        return $this->hasMany(City::class, ['city_country_id' => 'country_id']);
    }
}
