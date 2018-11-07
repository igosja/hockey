<?php

namespace common\models;

/**
 * Class RatingCountry
 * @package common\models
 *
 * @property int $rating_country_id
 * @property int $rating_country_auto_place
 * @property int $rating_country_country_id
 * @property int $rating_country_league_place
 * @property int $rating_country_stadium_place
 */
class RatingCountry extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%rating_country}}';
    }

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
}
