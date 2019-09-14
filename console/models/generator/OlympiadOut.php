<?php

namespace console\models\generator;

use common\models\Game;
use common\models\Olympiad;
use common\models\ParticipantOlympiad;
use common\models\Schedule;
use common\models\Season;
use common\models\Stage;
use common\models\TournamentType;

/**
 * Class OlympiadOut
 * @package console\models\generator
 */
class OlympiadOut
{
    /**
     * @return void
     */
    public function execute()
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
            Stage::ROUND_OF_16,
            Stage::QUARTER,
            Stage::SEMI,
            Stage::FINAL_GAME,
        ])) {
            $gameArray = Game::find()
                ->where(['game_schedule_id' => $schedule->schedule_id])
                ->orderBy(['game_id' => SORT_ASC])
                ->all();
            foreach ($gameArray as $game) {
                $homeScore = $game->game_home_score + $game->game_home_score_shootout;
                $guestScore = $game->game_guest_score + $game->game_guest_score_shootout;

                if ($homeScore > $guestScore) {
                    $looseNationalId = $game->game_guest_national_id;
                } else {
                    $looseNationalId = $game->game_home_national_id;
                }

                ParticipantOlympiad::updateAll(
                    ['participant_olympiad_stage_id' => $schedule->schedule_stage_id],
                    ['participant_olympiad_national_id' => $looseNationalId, 'participant_olympiad_season_id' => $seasonId]
                );
            }
        } elseif (Stage::TOUR_OLYMPIAD_5 == $schedule->schedule_stage_id) {
            $olympiadArray = Olympiad::find()
                ->where(['olympiad_place' => [5, 6], 'olympiad_season_id' => $seasonId])
                ->orderBy(['olympiad_id' => SORT_ASC])
                ->all();
            foreach ($olympiadArray as $olympiad) {
                ParticipantOlympiad::updateAll(
                    ['participant_olympiad_stage_id' => $olympiad->olympiad_place],
                    [
                        'participant_olympiad_national_id' => $olympiad->olympiad_national_id,
                        'participant_olympiad_season_id' => $seasonId
                    ]
                );
            }

            $olympiadArray = Olympiad::find()
                ->where(['olympiad_place' => [1, 2, 3, 4], 'olympiad_season_id' => $seasonId])
                ->orderBy(['olympiad_id' => SORT_ASC])
                ->all();
            foreach ($olympiadArray as $olympiad) {
                $stage8 = 0;
                $stage4 = 0;
                $stage2 = 0;
                $stage1 = 1;

                if (1 == $olympiad->olympiad_place) {
                    if (1 == $olympiad->olympiad_group) {
                        $stage8 = 1;
                        $stage4 = 1;
                        $stage2 = 1;
                    } elseif (2 == $olympiad->olympiad_group) {
                        $stage8 = 4;
                        $stage4 = 4;
                        $stage2 = 2;
                    } elseif (3 == $olympiad->olympiad_group) {
                        $stage8 = 5;
                        $stage4 = 2;
                        $stage2 = 1;
                    } elseif (4 == $olympiad->olympiad_group) {
                        $stage8 = 8;
                        $stage4 = 3;
                        $stage2 = 2;
                    }
                } elseif (2 == $olympiad->olympiad_place) {
                    if (1 == $olympiad->olympiad_group) {
                        $stage8 = 2;
                        $stage4 = 2;
                        $stage2 = 1;
                    } elseif (2 == $olympiad->olympiad_group) {
                        $stage8 = 3;
                        $stage4 = 3;
                        $stage2 = 2;
                    } elseif (3 == $olympiad->olympiad_group) {
                        $stage8 = 6;
                        $stage4 = 1;
                        $stage2 = 1;
                    } elseif (4 == $olympiad->olympiad_group) {
                        $stage8 = 7;
                        $stage4 = 4;
                        $stage2 = 2;
                    }
                } elseif (3 == $olympiad->olympiad_place) {
                    if (1 == $olympiad->olympiad_group) {
                        $stage8 = 3;
                        $stage4 = 3;
                        $stage2 = 2;
                    } elseif (2 == $olympiad->olympiad_group) {
                        $stage8 = 2;
                        $stage4 = 2;
                        $stage2 = 1;
                    } elseif (3 == $olympiad->olympiad_group) {
                        $stage8 = 7;
                        $stage4 = 4;
                        $stage2 = 2;
                    } elseif (4 == $olympiad->olympiad_group) {
                        $stage8 = 6;
                        $stage4 = 1;
                        $stage2 = 1;
                    }
                } elseif (4 == $olympiad->olympiad_place) {
                    if (1 == $olympiad->olympiad_group) {
                        $stage8 = 4;
                        $stage4 = 4;
                        $stage2 = 2;
                    } elseif (2 == $olympiad->olympiad_group) {
                        $stage8 = 1;
                        $stage4 = 1;
                        $stage2 = 1;
                    } elseif (3 == $olympiad->olympiad_group) {
                        $stage8 = 8;
                        $stage4 = 3;
                        $stage2 = 2;
                    } elseif (4 == $olympiad->olympiad_group) {
                        $stage8 = 5;
                        $stage4 = 2;
                        $stage2 = 1;
                    }
                }

                ParticipantOlympiad::updateAll(
                    [
                        'participant_olympiad_stage_1' => $stage1,
                        'participant_olympiad_stage_2' => $stage2,
                        'participant_olympiad_stage_4' => $stage4,
                        'participant_olympiad_stage_8' => $stage8,
                    ],
                    [
                        'participant_olympiad_national_id' => $olympiad->olympiad_national_id,
                        'participant_olympiad_season_id' => $seasonId,
                    ]
                );
            }
        }
    }
}