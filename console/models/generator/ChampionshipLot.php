<?php

namespace console\models\generator;

use common\models\Game;
use common\models\ParticipantChampionship;
use common\models\Schedule;
use common\models\Season;
use common\models\Stage;
use common\models\TournamentType;

/**
 * Class ChampionshipLot
 * @package console\models\generator
 */
class ChampionshipLot
{
    /**
     * @throws \Exception
     */
    public function execute()
    {
        $schedule = Schedule::find()
            ->where('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->andWhere([
                'schedule_tournament_type_id' => TournamentType::CHAMPIONSHIP,
                'schedule_stage_id' => [Stage::TOUR_30, Stage::QUARTER, Stage::SEMI],
            ])
            ->limit(1)
            ->one();
        if (!$schedule) {
            return;
        }

        $seasonId = Season::getCurrentSeason();

        if (Stage::TOUR_30 == $schedule->schedule_stage_id) {
            $stageArray = Schedule::find()
                ->where([
                    'schedule_season_id' => $seasonId,
                    'schedule_stage_id' => Stage::QUARTER,
                    'schedule_tournament_type_id' => TournamentType::CHAMPIONSHIP,
                ])
                ->orderBy(['schedule_id' => SORT_ASC])
                ->limit(2)
                ->all();

            $countryArray = ParticipantChampionship::find()
                ->where(['participant_championship_season_id' => $seasonId])
                ->groupBy(['participant_championship_country_id'])
                ->orderBy(['participant_championship_country_id' => SORT_ASC])
                ->all();
            foreach ($countryArray as $country) {
                $divisionArray = ParticipantChampionship::find()
                    ->where([
                        'participant_championship_season_id' => $seasonId,
                        'participant_championship_country_id' => $country->participant_championship_country_id,
                    ])
                    ->groupBy(['participant_championship_division_id'])
                    ->orderBy(['participant_championship_division_id' => SORT_ASC])
                    ->all();
                foreach ($divisionArray as $division) {
                    for ($i = 1; $i <= 4; $i++) {
                        $teamArray = ParticipantChampionship::find()
                            ->joinWith(['championship'])
                            ->with(['championship.team'])
                            ->where([
                                'participant_championship_season_id' => $seasonId,
                                'participant_championship_country_id' => $country->participant_championship_country_id,
                                'participant_championship_division_id' => $division->participant_championship_division_id,
                                'participant_championship_stage_4' => $i,
                                'participant_championship_stage_id' => 0,
                            ])
                            ->orderBy(['championship_place' => SORT_ASC])
                            ->limit(2)
                            ->all();

                        $model = new Game();
                        $model->game_guest_team_id = $teamArray[1]->participant_championship_team_id;
                        $model->game_home_team_id = $teamArray[0]->participant_championship_team_id;
                        $model->game_schedule_id = $stageArray[0]->schedule_id;
                        $model->game_stadium_id = $teamArray[0]->championship->team->team_stadium_id;
                        $model->save();

                        $model = new Game();
                        $model->game_guest_team_id = $teamArray[0]->participant_championship_team_id;
                        $model->game_home_team_id = $teamArray[1]->participant_championship_team_id;
                        $model->game_schedule_id = $stageArray[1]->schedule_id;
                        $model->game_stadium_id = $teamArray[1]->championship->team->team_stadium_id;
                        $model->save();
                    }
                }
            }
        } elseif (Stage::QUARTER == $schedule->schedule_stage_id) {
            $check = Schedule::find()
                ->where(['schedule_tournament_type_id' => TournamentType::CHAMPIONSHIP])
                ->andWhere(['>', 'schedule_id', $schedule->schedule_id])
                ->orderBy(['schedule_id' => SORT_ASC])
                ->limit(1)
                ->one();
            if (Stage::SEMI == $check->schedule_stage_id) {
                $stageArray = Schedule::find()
                    ->where([
                        'schedule_season_id' => $seasonId,
                        'schedule_stage_id' => Stage::SEMI,
                        'schedule_tournament_type_id' => TournamentType::CHAMPIONSHIP,
                    ])
                    ->orderBy(['schedule_id' => SORT_ASC])
                    ->limit(2)
                    ->all();

                $countryArray = ParticipantChampionship::find()
                    ->where(['participant_championship_season_id' => $seasonId])
                    ->groupBy(['participant_championship_country_id'])
                    ->orderBy(['participant_championship_country_id' => SORT_ASC])
                    ->all();
                foreach ($countryArray as $country) {
                    $divisionArray = ParticipantChampionship::find()
                        ->where([
                            'participant_championship_season_id' => $seasonId,
                            'participant_championship_country_id' => $country->participant_championship_country_id,
                        ])
                        ->groupBy(['participant_championship_division_id'])
                        ->orderBy(['participant_championship_division_id' => SORT_ASC])
                        ->all();
                    foreach ($divisionArray as $division) {
                        for ($i = 1; $i <= 2; $i++) {
                            $teamArray = ParticipantChampionship::find()
                                ->joinWith(['championship'])
                                ->with(['championship.team'])
                                ->where([
                                    'participant_championship_season_id' => $seasonId,
                                    'participant_championship_country_id' => $country->participant_championship_country_id,
                                    'participant_championship_division_id' => $division->participant_championship_division_id,
                                    'participant_championship_stage_2' => $i,
                                    'participant_championship_stage_id' => 0,
                                ])
                                ->orderBy(['championship_place' => SORT_ASC])
                                ->limit(2)
                                ->all();

                            $model = new Game();
                            $model->game_guest_team_id = $teamArray[1]->participant_championship_team_id;
                            $model->game_home_team_id = $teamArray[0]->participant_championship_team_id;
                            $model->game_schedule_id = $stageArray[0]->schedule_id;
                            $model->game_stadium_id = $teamArray[0]->championship->team->team_stadium_id;
                            $model->save();

                            $model = new Game();
                            $model->game_guest_team_id = $teamArray[0]->participant_championship_team_id;
                            $model->game_home_team_id = $teamArray[1]->participant_championship_team_id;
                            $model->game_schedule_id = $stageArray[1]->schedule_id;
                            $model->game_stadium_id = $teamArray[1]->championship->team->team_stadium_id;
                            $model->save();
                        }
                    }
                }
            }
        } elseif (Stage::SEMI == $schedule->schedule_stage_id) {
            $check = Schedule::find()
                ->where(['schedule_tournament_type_id' => TournamentType::CHAMPIONSHIP])
                ->andWhere(['>', 'schedule_id', $schedule->schedule_id])
                ->orderBy(['schedule_id' => SORT_ASC])
                ->limit(1)
                ->one();
            if (Stage::FINAL_GAME == $check->schedule_stage_id) {
                $stageArray = Schedule::find()
                    ->where([
                        'schedule_season_id' => $seasonId,
                        'schedule_stage_id' => Stage::FINAL_GAME,
                        'schedule_tournament_type_id' => TournamentType::CHAMPIONSHIP,
                    ])
                    ->orderBy(['schedule_id' => SORT_ASC])
                    ->limit(3)
                    ->all();

                $countryArray = ParticipantChampionship::find()
                    ->where(['participant_championship_season_id' => $seasonId])
                    ->groupBy(['participant_championship_country_id'])
                    ->orderBy(['participant_championship_country_id' => SORT_ASC])
                    ->all();
                foreach ($countryArray as $country) {
                    $divisionArray = ParticipantChampionship::find()
                        ->where([
                            'participant_championship_season_id' => $seasonId,
                            'participant_championship_country_id' => $country->participant_championship_country_id,
                        ])
                        ->groupBy(['participant_championship_division_id'])
                        ->orderBy(['participant_championship_division_id' => SORT_ASC])
                        ->all();
                    foreach ($divisionArray as $division) {
                        $teamArray = ParticipantChampionship::find()
                            ->joinWith(['championship'])
                            ->with(['championship.team'])
                            ->where([
                                'participant_championship_season_id' => $seasonId,
                                'participant_championship_country_id' => $country->participant_championship_country_id,
                                'participant_championship_division_id' => $division->participant_championship_division_id,
                                'participant_championship_stage_1' => 1,
                                'participant_championship_stage_id' => 0,
                            ])
                            ->orderBy(['championship_place' => SORT_ASC])
                            ->limit(2)
                            ->all();

                        $model = new Game();
                        $model->game_guest_team_id = $teamArray[1]->participant_championship_team_id;
                        $model->game_home_team_id = $teamArray[0]->participant_championship_team_id;
                        $model->game_schedule_id = $stageArray[0]->schedule_id;
                        $model->game_stadium_id = $teamArray[0]->championship->team->team_stadium_id;
                        $model->save();

                        $model = new Game();
                        $model->game_guest_team_id = $teamArray[0]->participant_championship_team_id;
                        $model->game_home_team_id = $teamArray[1]->participant_championship_team_id;
                        $model->game_schedule_id = $stageArray[1]->schedule_id;
                        $model->game_stadium_id = $teamArray[1]->championship->team->team_stadium_id;
                        $model->save();

                        $model = new Game();
                        $model->game_guest_team_id = $teamArray[1]->participant_championship_team_id;
                        $model->game_home_team_id = $teamArray[0]->participant_championship_team_id;
                        $model->game_schedule_id = $stageArray[2]->schedule_id;
                        $model->game_stadium_id = $teamArray[0]->championship->team->team_stadium_id;
                        $model->save();
                    }
                }
            }
        }
    }
}
