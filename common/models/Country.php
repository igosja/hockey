<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Country
 * @package common\models
 *
 * @property int $country_id
 * @property int $country_auto
 * @property int $country_finance
 * @property int $country_game
 * @property string $country_name
 * @property int $country_president_id
 * @property int $country_president_vice_id
 * @property int $country_stadium_capacity
 *
 * @property City[] $city
 * @property User $vice
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

    /**
     * @return ActiveQuery
     */
    public function getVice(): ActiveQuery
    {
        return $this->hasOne(User::class, ['user_id' => 'country_president_vice_id']);
    }
}
