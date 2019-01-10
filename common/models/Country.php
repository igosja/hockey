<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

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
 * @property User $president
 * @property User $vice
 */
class Country extends AbstractActiveRecord
{
    /**
     * USA 157
     */
    const DEFAULT_ID = 157;

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

    /**
     * @return string
     */
    public function countryImage()
    {
        return Html::img(
            '/img/country/12/' . $this->country_id . '.png',
            [
                'alt' => $this->country_name,
                'title' => $this->country_name,
            ]
        );
    }

    /**
     * @return string
     */
    public function countryImageLink()
    {
        return Html::a($this->countryImage(), ['country/news', 'id' => $this->country_id]);
    }

    /**
     * @return string
     */
    public function countryLink()
    {
        return $this->countryImage() . ' ' . Html::a($this->country_name, ['country/news', 'id' => $this->country_id]);
    }

    /**
     * @return array
     */
    public static function selectOptions()
    {
        return ArrayHelper::map(self::find()->where(['!=', 'country_id', 0])->all(), 'country_id', 'country_name');
    }

    /**
     * @return ActiveQuery
     */
    public function getCity()
    {
        return $this->hasMany(City::class, ['city_country_id' => 'country_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPresident()
    {
        return $this->hasOne(User::class, ['user_id' => 'country_president_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getVice()
    {
        return $this->hasOne(User::class, ['user_id' => 'country_president_vice_id']);
    }
}
