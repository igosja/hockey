<?php

namespace console\models\generator;

use common\models\Game;
use common\models\ParticipantChampionship;
use common\models\ParticipantLeague;
use common\models\Schedule;
use common\models\Season;
use common\models\Stage;
use common\models\TournamentType;

/**
 * Class ChampionshipAddGame
 * @package console\models\generator
 */
class ChampionshipAddGame
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
                'schedule_stage_id' => [Stage::QUARTER, Stage::SEMI, Stage::FINAL_GAME]
            ])
            ->limit(1)
            ->one();
        if (!$schedule) {
            return;
        }

        $seasonId = Season::getCurrentSeason();

        if (in_array($schedule->schedule_stage_id, [Stage::QUARTER, Stage::SEMI])) {
            $gameArray = Game::find()
                ->where(['game_schedule_id' => $schedule->schedule_id])
                ->orderBy(['game_id' => SORT_ASC])
                ->each();
            foreach ($gameArray as $game) {
                /**
                 * @var Game $game
                 */
                $prevArray = Game::find()
                    ->joinWith(['schedule'])
                    ->where([
                        'or',
                        [
                            'game_home_team_id' => $game->game_home_team_id,
                            'game_guest_team_id' => $game->game_guest_team_id
                        ],
                        [
                            'game_home_team_id' => $game->game_guest_team_id,
                            'game_guest_team_id' => $game->game_home_team_id
                        ],
                    ])
                    ->andWhere(['!=', 'game_played', 0])
                    ->andWhere([
                        'schedule.schedule_tournament_type_id' => TournamentType::CHAMPIONSHIP,
                        'schedule.schedule_stage_id' => $schedule->schedule_stage_id,
                        'schedule.schedule_season_id' => $seasonId,
                    ])
                    ->orderBy(['game_id' => SORT_ASC])
                    ->all();
                if (count($prevArray) > 1) {
                    $homeWin = 0;
                    $guestWin = 0;

                    foreach ($prevArray as $prev) {
                        if ($prev->game_home_score + $prev->game_home_score_shootout > $prev->game_guest_score + $prev->game_guest_score_shootout) {
                            if ($game->game_home_team_id == $prev->game_home_team_id) {
                                $homeWin++;
                            } else {
                                $guestWin++;
                            }
                        } else {
                            if ($game->game_home_team_id == $prev->game_home_team_id) {
                                $guestWin++;
                            } else {
                                $homeWin++;
                            }
                        }
                    }

                    if (in_array(2, [$homeWin, $guestWin])) {
                        if (2 == $homeWin) {
                            $looseTeamId = $game->game_guest_team_id;
                        } else {
                            $looseTeamId = $game->game_home_team_id;
                        }

                        $model = ParticipantChampionship::find()
                            ->where([
                                'participant_championship_team_id' => $looseTeamId,
                                'participant_championship_season_id' => $seasonId,
                                'participant_championship_stage_id' => 0,
                            ])
                            ->limit(1)
                            ->one();
                        if ($model) {
                            $model->participant_championship_stage_id = $schedule->schedule_stage_id;
                            $model->save();
                        }
                    } else {
                        $stage = Schedule::find()
                            ->where([
                                'schedule_season_id' => $seasonId,
                                'schedule_stage_id' => $schedule->schedule_stage_id,
                                'schedule_tournament_type_id' => TournamentType::CHAMPIONSHIP,
                            ])
                            ->orderBy(['schedule_id' => SORT_ASC])
                            ->offset(2)
                            ->limit(1)
                            ->one();

                        $teamArray = ParticipantChampionship::find()
                            ->joinWith(['championship'])
                            ->where([
                                'participant_championship_team_id' => [
                                    $game->game_home_team_id,
                                    $game->game_guest_team_id
                                ],
                                'participant_championship_season_id' => $seasonId
                            ])
                            ->orderBy(['championship_place' => SORT_ASC])
                            ->limit(2)
                            ->all();

                        $model = new Game();
                        $model->game_guest_team_id = $teamArray[1]->championship->championship_team_id;
                        $model->game_home_team_id = $teamArray[0]->championship->championship_team_id;
                        $model->game_schedule_id = $stage->schedule_id;
                        $model->game_stadium_id = $teamArray[0]->championship->team->team_stadium_id;
                        $model->save();
                    }
                }
            }
        } elseif (Stage::FINAL_GAME == $schedule->schedule_stage_id) {
            $gameArray = Game::find()
                ->where(['game_schedule_id' => $schedule->schedule_id])
                ->orderBy(['game_id' => SORT_ASC])
                ->each();
            foreach ($gameArray as $game) {
                /**
                 * @var Game $game
                 */
                $prevArray = Game::find()
                    ->joinWith(['schedule'])
                    ->where([
                        'or',
                        [
                            'game_home_team_id' => $game->game_home_team_id,
                            'game_guest_team_id' => $game->game_guest_team_id
                        ],
                        [
                            'game_home_team_id' => $game->game_guest_team_id,
                            'game_guest_team_id' => $game->game_home_team_id
                        ],
                    ])
                    ->andWhere(['!=', 'game_played', 0])
                    ->andWhere([
                        'schedule.schedule_tournament_type_id' => TournamentType::CHAMPIONSHIP,
                        'schedule.schedule_stage_id' => $schedule->schedule_stage_id,
                        'schedule.schedule_season_id' => $seasonId,
                    ])
                    ->orderBy(['game_id' => SORT_ASC])
                    ->all();
                if (count($prevArray) > 2) {
                    $homeWin = 0;
                    $guestWin = 0;

                    foreach ($prevArray as $prev) {
                        if ($prev->game_home_score + $prev->game_home_score_shootout > $prev->game_guest_score + $prev->game_guest_score_shootout) {
                            if ($game->game_home_team_id == $prev->game_home_team_id) {
                                $homeWin++;
                            } else {
                                $guestWin++;
                            }
                        } else {
                            if ($game->game_home_team_id == $prev->game_home_team_id) {
                                $guestWin++;
                            } else {
                                $homeWin++;
                            }
                        }
                    }

                    if (in_array(3, [$homeWin, $guestWin])) {
                        if (3 == $homeWin) {
                            $looseTeamId = $game->game_guest_team_id;
                        } else {
                            $looseTeamId = $game->game_home_team_id;
                        }

                        $model = ParticipantChampionship::find()
                            ->where([
                                'participant_championship_team_id' => $looseTeamId,
                                'participant_championship_season_id' => $seasonId,
                                'participant_championship_stage_id' => 0,
                            ])
                            ->limit(1)
                            ->one();
                        if ($model) {
                            $model->participant_championship_stage_id = $schedule->schedule_stage_id;
                            $model->save();
                        }
                    } elseif ((3 == count($prevArray) && in_array(1, [$homeWin, $guestWin])) || 4 == count($prevArray)) {
                        if (3 == count($prevArray) && in_array(1, [$homeWin, $guestWin])) {
                            $offset = 3;
                        } else {
                            $offset = 4;
                        }

                        $stage = Schedule::find()
                            ->where([
                                'schedule_season_id' => $seasonId,
                                'schedule_stage_id' => $schedule->schedule_stage_id,
                                'schedule_tournament_type_id' => TournamentType::CHAMPIONSHIP,
                            ])
                            ->orderBy(['schedule_id' => SORT_ASC])
                            ->offset($offset)
                            ->limit(1)
                            ->one();

                        $teamArray = ParticipantChampionship::find()
                            ->joinWith(['championship'])
                            ->where([
                                'participant_championship_team_id' => [
                                    $game->game_home_team_id,
                                    $game->game_guest_team_id
                                ],
                                'participant_championship_season_id' => $seasonId
                            ])
                            ->orderBy(['championship_place' => SORT_ASC])
                            ->limit(2)
                            ->all();

                        if (in_array(count($prevArray), [2, 3]) && in_array(1, [$homeWin, $guestWin])) {
                            $team1 = $teamArray[1]->participant_championship_team_id;
                            $stadiumId = $teamArray[1]->championship->team->team_stadium_id;
                            $team2 = $teamArray[0]->participant_championship_team_id;
                        } else {
                            $team1 = $teamArray[0]->participant_championship_team_id;
                            $stadiumId = $teamArray[0]->championship->team->team_stadium_id;
                            $team2 = $teamArray[1]->participant_championship_team_id;
                        }

                        $model = new Game();
                        $model->game_guest_team_id = $team2;
                        $model->game_home_team_id = $team1;
                        $model->game_schedule_id = $stage->schedule_id;
                        $model->game_stadium_id = $stadiumId;
                        $model->save();
                    } else {
                        $stage = Schedule::find()
                            ->where([
                                'schedule_season_id' => $seasonId,
                                'schedule_stage_id' => $schedule->schedule_stage_id,
                                'schedule_tournament_type_id' => TournamentType::CHAMPIONSHIP,
                            ])
                            ->orderBy(['schedule_id' => SORT_ASC])
                            ->offset(2)
                            ->limit(1)
                            ->one();

                        $teamArray = ParticipantChampionship::find()
                            ->joinWith(['championship'])
                            ->where([
                                'participant_championship_team_id' => [
                                    $game->game_home_team_id,
                                    $game->game_guest_team_id
                                ],
                                'participant_championship_season_id' => $seasonId
                            ])
                            ->orderBy(['championship_place' => SORT_ASC])
                            ->limit(2)
                            ->all();

                        $model = new Game();
                        $model->game_guest_team_id = $teamArray[1]->championship->championship_team_id;
                        $model->game_home_team_id = $teamArray[0]->championship->championship_team_id;
                        $model->game_schedule_id = $stage->schedule_id;
                        $model->game_stadium_id = $teamArray[0]->championship->team->team_stadium_id;
                        $model->save();
                    }
                }
            }
        }
    }
}