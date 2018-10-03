<?php

namespace console\models\generator;

use common\models\Game;
use common\models\League;
use common\models\ParticipantLeague;
use common\models\Schedule;
use common\models\Season;
use common\models\Stage;
use common\models\TournamentType;

/**
 * Class LeagueOut
 * @package console\models\generator
 */
class LeagueOut
{
    /**
     * @return void
     */
    public function execute(): void
    {
        $schedule = Schedule::find()
            ->where('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->andWhere(['schedule_tournament_type_id' => TournamentType::LEAGUE])
            ->limit(1)
            ->one();
        if (!$schedule) {
            return;
        }

        $seasonId = Season::getCurrentSeason();

        if (in_array($schedule->schedule_stage_id, [
            Stage::QUALIFY_1,
            Stage::QUALIFY_2,
            Stage::QUALIFY_3,
            Stage::ROUND_OF_16,
            Stage::QUARTER,
            Stage::SEMI,
            Stage::FINAL,
        ])) {
            $gameArray = Game::find()
                ->where(['game_schedule_id' => $schedule->schedule_id])
                ->orderBy(['game_id' => SORT_ASC])
                ->all();
            foreach ($gameArray as $game) {
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
                        'schedule_tournament_type_id' => TournamentType::LEAGUE,
                        'schedule_stage_id' => $schedule->schedule_stage_id,
                        'schedule_season_id' => $seasonId,
                    ])
                    ->orderBy(['game_id' => SORT_ASC])
                    ->all();

                if (count($prevArray) > 1) {
                    $homeScore = 0;
                    $guestScore = 0;

                    foreach ($prevArray as $prev) {
                        if ($game->game_home_team_id == $prev->game_home_team_id) {
                            $homeScore = $homeScore + $prev->game_home_score + $prev->game_home_score_shootout;
                            $guestScore = $guestScore + $prev->game_guest_score + $prev->game_guest_score_shootout;
                        } else {
                            $homeScore = $homeScore + $prev->game_guest_score + $prev->game_guest_score_shootout;
                            $guestScore = $guestScore + $prev->game_home_score + $prev->game_home_score_shootout;
                        }
                    }

                    if ($homeScore > $guestScore) {
                        $looseTeamId = $game->game_guest_team_id;
                    } else {
                        $looseTeamId = $game->game_home_team_id;
                    }

                    ParticipantLeague::updateAll(
                        ['participant_league_stage_id' => $schedule->schedule_stage_id],
                        ['participant_league_team_id' => $looseTeamId, 'participant_league_season_id' => $seasonId]
                    );
                }
            }
        } elseif (Stage::TOUR_LEAGUE_6 == $schedule->schedule_stage_id) {
            $leagueArray = League::find()
                ->where(['league_place' => [3, 4], 'league_season_id' => $seasonId])
                ->orderBy(['league_id' => SORT_ASC])
                ->all();
            foreach ($leagueArray as $league) {
                ParticipantLeague::updateAll(
                    ['participant_league_stage_id' => $league->league_place],
                    [
                        'participant_league_team_id' => $league->league_team_id,
                        'participant_league_season_id' => $seasonId
                    ]
                );
            }

            $leagueArray = League::find()
                ->where(['league_place' => [1, 2], 'league_season_id' => $seasonId])
                ->orderBy(['league_id' => SORT_ASC])
                ->all();
            foreach ($leagueArray as $league) {
                $stage8 = 0;
                $stage4 = 0;
                $stage2 = 0;
                $stage1 = 1;

                if (1 == $league->league_place) {
                    if (1 == $league->league_group) {
                        $stage8 = 1;
                        $stage4 = 1;
                        $stage2 = 1;
                    } elseif (2 == $league->league_group) {
                        $stage8 = 5;
                        $stage4 = 3;
                        $stage2 = 2;
                    } elseif (3 == $league->league_group) {
                        $stage8 = 2;
                        $stage4 = 1;
                        $stage2 = 1;
                    } elseif (4 == $league->league_group) {
                        $stage8 = 6;
                        $stage4 = 3;
                        $stage2 = 2;
                    } elseif (5 == $league->league_group) {
                        $stage8 = 3;
                        $stage4 = 2;
                        $stage2 = 1;
                    } elseif (6 == $league->league_group) {
                        $stage8 = 7;
                        $stage4 = 4;
                        $stage2 = 2;
                    } elseif (7 == $league->league_group) {
                        $stage8 = 4;
                        $stage4 = 2;
                        $stage2 = 1;
                    } elseif (8 == $league->league_group) {
                        $stage8 = 8;
                        $stage4 = 4;
                        $stage2 = 2;
                    }
                } elseif (2 == $league->league_place) {
                    if (1 == $league->league_group) {
                        $stage8 = 8;
                        $stage4 = 4;
                        $stage2 = 2;
                    } elseif (2 == $league->league_group) {
                        $stage8 = 1;
                        $stage4 = 1;
                        $stage2 = 1;
                    } elseif (3 == $league->league_group) {
                        $stage8 = 5;
                        $stage4 = 3;
                        $stage2 = 2;
                    } elseif (4 == $league->league_group) {
                        $stage8 = 2;
                        $stage4 = 1;
                        $stage2 = 1;
                    } elseif (5 == $league->league_group) {
                        $stage8 = 6;
                        $stage4 = 3;
                        $stage2 = 2;
                    } elseif (6 == $league->league_group) {
                        $stage8 = 3;
                        $stage4 = 2;
                        $stage2 = 1;
                    } elseif (7 == $league->league_group) {
                        $stage8 = 7;
                        $stage4 = 4;
                        $stage2 = 2;
                    } elseif (8 == $league->league_group) {
                        $stage8 = 4;
                        $stage4 = 2;
                        $stage2 = 1;
                    }
                }

                ParticipantLeague::updateAll(
                    [
                        'participant_league_stage_1' => $stage1,
                        'participant_league_stage_2' => $stage2,
                        'participant_league_stage_4' => $stage4,
                        'participant_league_stage_8' => $stage8,
                    ],
                    [
                        'participant_league_team_id' => $league->league_team_id,
                        'participant_league_season_id' => $seasonId,
                    ]
                );
            }
        }
    }
}