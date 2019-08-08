<?php

namespace common\models;

/**
 * Class RatingType
 * @package common\models
 *
 * @property int $rating_type_id
 * @property string $rating_type_name
 * @property string $rating_type_order
 * @property int $rating_type_rating_chapter_id
 */
class RatingType extends AbstractActiveRecord
{
    const COUNTRY_AUTO = 12;
    const COUNTRY_LEAGUE = 13;
    const COUNTRY_STADIUM = 11;
    const TEAM_AGE = 2;
    const TEAM_BASE = 5;
    const TEAM_FINANCE = 15;
    const TEAM_PLAYER = 8;
    const TEAM_POWER = 1;
    const TEAM_PRICE_BASE = 6;
    const TEAM_PRICE_STADIUM = 7;
    const TEAM_PRICE_TOTAL = 9;
    const TEAM_SALARY = 14;
    const TEAM_STADIUM = 3;
    const TEAM_VISITOR = 4;
    const USER_RATING = 10;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%rating_type}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['rating_type_id', 'rating_type_rating_chapter_id'], 'integer'],
            [['rating_type_name'], 'required'],
            [['rating_type_name'], 'string', 'max' => 255],
            [['rating_type_name'], 'trim'],
        ];
    }
}
