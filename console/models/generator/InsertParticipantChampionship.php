<?php

namespace console\models\generator;

use common\models\Championship;
use common\models\ParticipantChampionship;
use common\models\Schedule;
use common\models\Season;
use common\models\Stage;
use common\models\TournamentType;
use Yii;

/**
 * Class InsertParticipantChampionship
 * @package console\models\generator
 */
class InsertParticipantChampionship
{
    /**
     * @throws \yii\db\Exception
     * @return void
     */
    public function execute()
    {
        $seasonId = Season::getCurrentSeason();

        $schedule = Schedule::find()
            ->where('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->andWhere([
                'schedule_tournament_type_id' => TournamentType::CHAMPIONSHIP,
                'schedule_stage_id' => Stage::TOUR_30,
            ])
            ->limit(1)
            ->one();
        if (!$schedule) {
            return;
        }

        $countryArray = Championship::find()
            ->where(['championship_season_id' => $seasonId])
            ->groupBy(['championship_country_id'])
            ->orderBy(['championship_country_id' => SORT_ASC])
            ->all();
        foreach ($countryArray as $country) {
            $countryId = $country->championship_country_id;

            $divisionArray = Championship::find()
                ->where([
                    'championship_country_id' => $countryId,
                    'championship_season_id' => $seasonId,
                ])
                ->groupBy(['championship_division_id'])
                ->orderBy(['championship_division_id' => SORT_ASC])
                ->all();
            foreach ($divisionArray as $division) {
                $divisionId = $division->championship_division_id;

                $teamArray = Championship::find()
                    ->where([
                        'championship_country_id' => $countryId,
                        'championship_division_id' => $divisionId,
                        'championship_season_id' => $seasonId,
                    ])
                    ->orderBy(['championship_place' => SORT_ASC])
                    ->limit(8)
                    ->all();

                $data = [
                    [$countryId, $divisionId, $seasonId, 1, 1, 1, $teamArray[0]->championship_team_id],
                    [$countryId, $divisionId, $seasonId, 1, 2, 3, $teamArray[1]->championship_team_id],
                    [$countryId, $divisionId, $seasonId, 1, 2, 4, $teamArray[2]->championship_team_id],
                    [$countryId, $divisionId, $seasonId, 1, 1, 2, $teamArray[3]->championship_team_id],
                    [$countryId, $divisionId, $seasonId, 1, 1, 2, $teamArray[4]->championship_team_id],
                    [$countryId, $divisionId, $seasonId, 1, 2, 4, $teamArray[5]->championship_team_id],
                    [$countryId, $divisionId, $seasonId, 1, 2, 3, $teamArray[6]->championship_team_id],
                    [$countryId, $divisionId, $seasonId, 1, 1, 1, $teamArray[7]->championship_team_id]
                ];

                Yii::$app->db
                    ->createCommand()
                    ->batchInsert(
                        ParticipantChampionship::tableName(),
                        [
                            'participant_championship_country_id',
                            'participant_championship_division_id',
                            'participant_championship_season_id',
                            'participant_championship_stage_1',
                            'participant_championship_stage_2',
                            'participant_championship_stage_4',
                            'participant_championship_team_id',
                        ],
                        $data
                    )
                    ->execute();
            }
        }
    }
}
