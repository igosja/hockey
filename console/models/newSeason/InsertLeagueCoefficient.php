<?php

namespace console\models\newSeason;

use common\models\LeagueCoefficient;
use common\models\ParticipantLeague;
use common\models\Season;
use Yii;
use yii\db\Exception;

/**
 * Class InsertLeagueCoefficient
 * @package console\models\newSeason
 */
class InsertLeagueCoefficient
{
    /**
     * @throws Exception
     * @return void
     */
    public function execute()
    {
        $seasonId = Season::getCurrentSeason() + 1;

        $participantLeagueArray = ParticipantLeague::find()
            ->where(['participant_league_season_id' => $seasonId])
            ->orderBy(['participant_league_id' => SORT_ASC])
            ->each();

        $data = [];
        foreach ($participantLeagueArray as $participantLeague) {
            /**
             * @var ParticipantLeague $participantLeague
             */
            $data[] = [
                $participantLeague->team->stadium->city->country->country_id,
                $seasonId,
                $participantLeague->participant_league_team_id,
            ];
        }

        Yii::$app->db
            ->createCommand()
            ->batchInsert(
                LeagueCoefficient::tableName(),
                [
                    'league_coefficient_country_id',
                    'league_coefficient_season_id',
                    'league_coefficient_team_id',
                ],
                $data
            )
            ->execute();
    }
}
