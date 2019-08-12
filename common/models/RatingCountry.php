<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class RatingCountry
 * @package common\models
 *
 * @property int $rating_country_id
 * @property int $rating_country_auto_place
 * @property int $rating_country_country_id
 * @property int $rating_country_league_place
 * @property int $rating_country_stadium_place
 *
 * @property Country $country
 */
class RatingCountry extends AbstractActiveRecord
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'rating_country_id',
                    'rating_country_auto_place',
                    'rating_country_country_id',
                    'rating_country_league_place',
                    'rating_country_stadium_place',
                ],
                'integer'
            ],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCountry(): ActiveQuery
    {
        return $this->hasOne(Country::class, ['country_id' => 'rating_country_country_id']);
    }
}
