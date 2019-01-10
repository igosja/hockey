<?php

namespace common\models;

/**
 * Class LeagueDistribution
 * @package common\models
 *
 * @property int $league_distribution_id
 * @property int $league_distribution_country_id
 * @property int $league_distribution_group
 * @property int $league_distribution_qualification_4
 * @property int $league_distribution_qualification_3
 * @property int $league_distribution_qualification_2
 * @property int $league_distribution_qualification_1
 * @property int $league_distribution_season_id
 */
class LeagueDistribution extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%league_distribution}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'league_distribution_id',
                    'league_distribution_country_id',
                    'league_distribution_group',
                    'league_distribution_qualification_4',
                    'league_distribution_qualification_3',
                    'league_distribution_qualification_2',
                    'league_distribution_qualification_1',
                    'league_distribution_season_id'
                ],
                'integer'
            ],
        ];
    }
}
