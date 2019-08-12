<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class RatingTeam
 * @package common\models
 *
 * @property int $rating_team_id
 * @property int $rating_team_age_place
 * @property int $rating_team_age_place_country
 * @property int $rating_team_base_place
 * @property int $rating_team_base_place_country
 * @property int $rating_team_finance_place
 * @property int $rating_team_finance_place_country
 * @property int $rating_team_player_place
 * @property int $rating_team_player_place_country
 * @property int $rating_team_power_vs_place
 * @property int $rating_team_power_vs_place_country
 * @property int $rating_team_price_base_place
 * @property int $rating_team_price_base_place_country
 * @property int $rating_team_price_stadium_place
 * @property int $rating_team_price_stadium_place_country
 * @property int $rating_team_price_total_place
 * @property int $rating_team_price_total_place_country
 * @property int $rating_team_salary_place
 * @property int $rating_team_salary_place_country
 * @property int $rating_team_stadium_place
 * @property int $rating_team_stadium_place_country
 * @property int $rating_team_team_id
 * @property int $rating_team_visitor_place
 * @property int $rating_team_visitor_place_country
 *
 * @property Team $team
 */
class RatingTeam extends AbstractActiveRecord
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'rating_team_id',
                    'rating_team_age_place',
                    'rating_team_age_place_country',
                    'rating_team_base_place',
                    'rating_team_base_place_country',
                    'rating_team_finance_place',
                    'rating_team_finance_place_country',
                    'rating_team_player_place',
                    'rating_team_player_place_country',
                    'rating_team_power_vs_place',
                    'rating_team_power_vs_place_country',
                    'rating_team_price_base_place',
                    'rating_team_price_base_place_country',
                    'rating_team_price_stadium_place',
                    'rating_team_price_stadium_place_country',
                    'rating_team_price_total_place',
                    'rating_team_price_total_place_country',
                    'rating_team_salary_place',
                    'rating_team_salary_place_country',
                    'rating_team_stadium_place',
                    'rating_team_stadium_place_country',
                    'rating_team_team_id',
                    'rating_team_visitor_place',
                    'rating_team_visitor_place_country',
                ],
                'integer'
            ],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getTeam(): ActiveQuery
    {
        return $this->hasOne(Team::class, ['team_id' => 'rating_team_team_id']);
    }
}
