<?php

namespace console\models\newSeason;

use common\models\LeagueDistribution;
use common\models\RatingCountry;
use common\models\Season;
use Yii;
use yii\db\Exception;

/**
 * Class LeagueLimit
 * @package console\models\newSeason
 */
class LeagueLimit
{
    /**
     * @throws Exception
     * @return void
     */
    public function execute()
    {
        $seasonId = Season::getCurrentSeason() + 2;

        $data = [];

        $ratingCountryArray = RatingCountry::find()
            ->orderBy(['rating_country_league_place'])
            ->all();
        foreach ($ratingCountryArray as $ratingCountry) {
            if ($ratingCountry->rating_country_league_place <= 4) {
                $data[] = [$ratingCountry->rating_country_country_id, 2, 1, 1, 0, $seasonId];
            } else {
                $data[] = [$ratingCountry->rating_country_country_id, 2, 1, 0, 1, $seasonId];
            }
        }

        Yii::$app->db
            ->createCommand()
            ->batchInsert(
                LeagueDistribution::tableName(),
                [
                    'league_distribution_country_id',
                    'league_distribution_group',
                    'league_distribution_qualification_3',
                    'league_distribution_qualification_2',
                    'league_distribution_qualification_1',
                    'league_distribution_season_id',
                ],
                $data
            )
            ->execute();
    }
}
