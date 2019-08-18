<?php

namespace console\models\generator;

use common\models\Game;
use common\models\ParticipantOlympiad;
use common\models\Schedule;
use common\models\Season;
use common\models\Stage;
use common\models\TournamentType;
use Exception;

/**
 * Class OlympiadLot
 * @package console\models\generator
 */
class OlympiadLot
{
    /**
     * @throws Exception
     */
    public function execute()
    {
        $schedule = Schedule::find()
            ->where('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->andWhere(['schedule_tournament_type_id' => TournamentType::OLYMPIAD])
            ->limit(1)
            ->one();
        if (!$schedule) {
            return;
        }

        $seasonId = Season::getCurrentSeason();

        if (Stage::TOUR_OLYMPIAD_5 == $schedule->schedule_stage_id) {
            $stage = Schedule::find()
                ->where([
                    'schedule_season_id' => $seasonId,
                    'schedule_stage_id' => Stage::ROUND_OF_16,
                    'schedule_tournament_type_id' => TournamentType::OLYMPIAD,
                ])
                ->limit(1)
                ->one();
            for ($i = 1; $i <= 8; $i++) {
                $nationalArray = ParticipantOlympiad::find()
                    ->where([
                        'participant_olympiad_season_id' => $seasonId,
                        'participant_olympiad_stage_8' => $i,
                        'participant_olympiad_stage_id' => 0,
                    ])
                    ->orderBy(['participant_olympiad_id' => SORT_ASC])
                    ->limit(2)
                    ->all();

                $model = new Game();
                $model->game_bonus_home = 0;
                $model->game_guest_national_id = $nationalArray[1]->participant_olympiad_national_id;
                $model->game_home_national_id = $nationalArray[0]->participant_olympiad_national_id;
                $model->game_schedule_id = $stage->schedule_id;
                $model->save();
            }
        } elseif (Stage::ROUND_OF_16 == $schedule->schedule_stage_id) {
            $stage = Schedule::find()
                ->where([
                    'schedule_season_id' => $seasonId,
                    'schedule_stage_id' => Stage::QUARTER,
                    'schedule_tournament_type_id' => TournamentType::OLYMPIAD,
                ])
                ->limit(1)
                ->one();
            for ($i = 1; $i <= 4; $i++) {
                $nationalArray = ParticipantOlympiad::find()
                    ->where([
                        'participant_olympiad_season_id' => $seasonId,
                        'participant_olympiad_stage_4' => $i,
                        'participant_olympiad_stage_id' => 0,
                    ])
                    ->orderBy(['participant_olympiad_id' => SORT_ASC])
                    ->limit(2)
                    ->all();

                $model = new Game();
                $model->game_bonus_home = 0;
                $model->game_guest_national_id = $nationalArray[1]->participant_olympiad_national_id;
                $model->game_home_national_id = $nationalArray[0]->participant_olympiad_national_id;
                $model->game_schedule_id = $stage->schedule_id;
                $model->save();
            }
        } elseif (Stage::QUARTER == $schedule->schedule_stage_id) {
            $stage = Schedule::find()
                ->where([
                    'schedule_season_id' => $seasonId,
                    'schedule_stage_id' => Stage::SEMI,
                    'schedule_tournament_type_id' => TournamentType::OLYMPIAD,
                ])
                ->limit(1)
                ->one();
            for ($i = 1; $i <= 2; $i++) {
                $nationalArray = ParticipantOlympiad::find()
                    ->where([
                        'participant_olympiad_season_id' => $seasonId,
                        'participant_olympiad_stage_2' => $i,
                        'participant_olympiad_stage_id' => 0,
                    ])
                    ->orderBy(['participant_league_id' => SORT_ASC])
                    ->limit(2)
                    ->all();

                $model = new Game();
                $model->game_bonus_home = 0;
                $model->game_guest_national_id = $nationalArray[1]->participant_olympiad_national_id;
                $model->game_home_national_id = $nationalArray[0]->participant_olympiad_national_id;
                $model->game_schedule_id = $stage->schedule_id;
                $model->save();
            }
        } elseif (Stage::SEMI == $schedule->schedule_stage_id) {
            $stage = Schedule::find()
                ->where([
                    'schedule_season_id' => $seasonId,
                    'schedule_stage_id' => Stage::FINAL_GAME,
                    'schedule_tournament_type_id' => TournamentType::OLYMPIAD,
                ])
                ->limit(1)
                ->one();
            $nationalArray = ParticipantOlympiad::find()
                ->where([
                    'participant_olympiad_season_id' => $seasonId,
                    'participant_olympiad_stage_1' => 1,
                    'participant_olympiad_stage_id' => 0,
                ])
                ->orderBy(['participant_league_id' => SORT_ASC])
                ->limit(2)
                ->all();

            $model = new Game();
            $model->game_bonus_home = 0;
            $model->game_guest_national_id = $nationalArray[1]->participant_olympiad_national_id;
            $model->game_home_national_id = $nationalArray[0]->participant_olympiad_national_id;
            $model->game_schedule_id = $stage->schedule_id;
            $model->save();
        }
    }
}