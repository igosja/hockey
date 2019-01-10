<?php

namespace console\models\generator;

use common\models\Game;
use common\models\Mood;
use common\models\UserRating;

/**
 * Class UpdateUserRating
 * @package console\models\generator
 */
class UpdateUserRating
{
    /**
     * @throws \Exception
     * @return void
     */
    public function execute()
    {
        $gameArray = Game::find()
            ->joinWith(['schedule'])
            ->with(['teamHome', 'teamGuest'])
            ->where(['game_played' => 0])
            ->andWhere('FROM_UNIXTIME(schedule_date, "%Y-%m-%d")=CURDATE()')
            ->orderBy(['game_id' => SORT_ASC])
            ->each();
        foreach ($gameArray as $game) {
            /**
             * @var Game $game
             */
            if (!$game->teamHome->team_user_id && !$game->teamGuest->team_user_id) {
                continue;
            }

            $guestAuto = 0;
            $guestCollisionLoose = 0;
            $guestCollisionWin = 0;
            $guestLoose = 0;
            $guestLooseEqual = 0;
            $guestLooseStrong = 0;
            $guestLooseSuper = 0;
            $guestLooseWeak = 0;
            $guestLooseOvertime = 0;
            $guestLooseOvertimeEqual = 0;
            $guestLooseOvertimeStrong = 0;
            $guestLooseOvertimeWeak = 0;
            $guestVsSuper = 0;
            $guestVsRest = 0;
            $guestWin = 0;
            $guestWinEqual = 0;
            $guestWinStrong = 0;
            $guestWinSuper = 0;
            $guestWinWeak = 0;
            $guestWinOvertime = 0;
            $guestWinOvertimeEqual = 0;
            $guestWinOvertimeStrong = 0;
            $guestWinOvertimeWeak = 0;
            $homeAuto = 0;
            $homeCollisionLoose = 0;
            $homeCollisionWin = 0;
            $homeLoose = 0;
            $homeLooseEqual = 0;
            $homeLooseStrong = 0;
            $homeLooseSuper = 0;
            $homeLooseWeak = 0;
            $homeLooseOvertime = 0;
            $homeLooseOvertimeEqual = 0;
            $homeLooseOvertimeStrong = 0;
            $homeLooseOvertimeWeak = 0;
            $homeVsSuper = 0;
            $homeVsRest = 0;
            $homeWin = 0;
            $homeWinEqual = 0;
            $homeWinStrong = 0;
            $homeWinSuper = 0;
            $homeWinWeak = 0;
            $homeWinOvertime = 0;
            $homeWinOvertimeEqual = 0;
            $homeWinOvertimeStrong = 0;
            $homeWinOvertimeWeak = 0;

            if ($game->game_guest_auto) {
                $guestAuto++;
            }

            if ($game->game_home_auto) {
                $homeAuto++;
            }

            if (1 == $game->game_guest_collision_1) {
                $guestCollisionWin++;
                $homeCollisionLoose++;
            } elseif (1 == $game->game_home_collision_1) {
                $guestCollisionLoose++;
                $homeCollisionWin++;
            }

            if (1 == $game->game_guest_collision_2) {
                $guestCollisionWin++;
                $homeCollisionLoose++;
            } elseif (1 == $game->game_home_collision_2) {
                $guestCollisionLoose++;
                $homeCollisionWin++;
            }

            if (1 == $game->game_guest_collision_3) {
                $guestCollisionWin++;
                $homeCollisionLoose++;
            } elseif (1 == $game->game_home_collision_3) {
                $guestCollisionLoose++;
                $homeCollisionWin++;
            }

            if (1 == $game->game_guest_collision_4) {
                $guestCollisionWin++;
                $homeCollisionLoose++;
            } elseif (1 == $game->game_home_collision_4) {
                $guestCollisionLoose++;
                $homeCollisionWin++;
            }

            if ($game->game_guest_score > $game->game_home_score && 0 == $game->game_guest_score_overtime) {
                $guestWin++;
                $homeLoose++;

                if ($game->game_guest_forecast / $game->game_home_forecast < 0.9) {
                    $guestWinStrong++;
                    $homeLooseWeak++;
                } elseif ($game->game_guest_forecast / $game->game_home_forecast > 1.1) {
                    $guestWinWeak++;
                    $homeLooseStrong++;
                } else {
                    $guestWinEqual++;
                    $homeLooseEqual++;
                }

                if (Mood::SUPER == $game->game_home_mood_id && Mood::SUPER != $game->game_guest_mood_id) {
                    $guestWinSuper++;
                    $homeLooseSuper++;
                }
            } elseif (($game->game_guest_score > $game->game_home_score && 0 != $game->game_guest_score_overtime) ||
                ($game->game_guest_score == $game->game_home_score && $game->game_guest_score_shootout > $game->game_home_score_shootout)) {
                $guestWinOvertime++;
                $homeLooseOvertime++;

                if ($game->game_guest_forecast / $game->game_home_forecast < 0.9) {
                    $guestWinOvertimeStrong++;
                    $homeLooseOvertimeWeak++;
                } elseif ($game->game_guest_forecast / $game->game_home_forecast > 1.1) {
                    $guestWinOvertimeWeak++;
                    $homeLooseOvertimeStrong++;
                } else {
                    $guestWinOvertimeEqual++;
                    $homeLooseOvertimeEqual++;
                }
            } elseif ($game->game_guest_score == $game->game_home_score && $game->game_guest_score_shootout == $game->game_home_score_shootout) {
                $guestLooseOvertime++;
                $homeLooseOvertime++;

                if ($game->game_guest_forecast / $game->game_home_forecast < 0.9) {
                    $guestLooseOvertimeStrong++;
                    $homeLooseOvertimeWeak++;
                } elseif ($game->game_guest_forecast / $game->game_home_forecast > 1.1) {
                    $guestLooseOvertimeWeak++;
                    $homeLooseOvertimeStrong++;
                } else {
                    $guestLooseOvertimeEqual++;
                    $homeLooseOvertimeEqual++;
                }
            } elseif (($game->game_guest_score < $game->game_home_score && 0 != $game->game_home_score_overtime) ||
                ($game->game_guest_score == $game->game_home_score && $game->game_guest_score_shootout < $game->game_home_score_shootout)) {
                $guestLooseOvertime++;
                $homeWinOvertime++;

                if ($game->game_guest_forecast / $game->game_home_forecast < 0.9) {
                    $guestLooseOvertimeStrong++;
                    $homeWinOvertimeWeak++;
                } elseif ($game->game_guest_forecast / $game->game_home_forecast > 1.1) {
                    $guestLooseOvertimeWeak++;
                    $homeWinOvertimeStrong++;
                } else {
                    $guestLooseOvertimeEqual++;
                    $homeWinOvertimeEqual++;
                }
            } elseif ($game->game_guest_score < $game->game_home_score && 0 == $game->game_home_score_overtime) {
                $guestLoose++;
                $homeWin++;

                if ($game->game_guest_forecast / $game->game_home_forecast < 0.9) {
                    $guestLooseStrong++;
                    $homeWinWeak++;
                } elseif ($game->game_guest_forecast / $game->game_home_forecast > 1.1) {
                    $guestLooseWeak++;
                    $homeWinStrong++;
                } else {
                    $guestLooseEqual++;
                    $homeWinEqual++;
                }

                if (Mood::SUPER != $game->game_home_mood_id && Mood::SUPER == $game->game_guest_mood_id) {
                    $guestLooseSuper++;
                    $homeWinSuper++;
                }
            }

            if (Mood::REST == $game->game_guest_mood_id && Mood::REST != $game->game_home_mood_id) {
                $homeVsRest++;
            } elseif (Mood::REST == $game->game_home_mood_id && Mood::REST != $game->game_guest_mood_id) {
                $guestVsRest++;
            }

            if (Mood::SUPER == $game->game_guest_mood_id && Mood::SUPER != $game->game_home_mood_id) {
                $homeVsSuper++;
            } elseif (Mood::SUPER == $game->game_home_mood_id && Mood::SUPER != $game->game_guest_mood_id) {
                $guestVsSuper++;
            }

            if ($game->teamGuest->team_user_id) {
                $model = UserRating::find()->where([
                    'user_rating_user_id' => $game->teamGuest->team_user_id,
                    'user_rating_season_id' => $game->schedule->schedule_season_id,
                ])->limit(1)->one();

                if ($model) {
                    $model->user_rating_auto = $model->user_rating_auto + $guestAuto;
                    $model->user_rating_collision_loose = $model->user_rating_collision_loose + $guestCollisionLoose;
                    $model->user_rating_collision_win = $model->user_rating_collision_win + $guestCollisionWin;
                    $model->user_rating_game = $model->user_rating_game + 1;
                    $model->user_rating_loose = $model->user_rating_loose + $guestLoose;
                    $model->user_rating_loose_equal = $model->user_rating_loose_equal + $guestLooseEqual;
                    $model->user_rating_loose_strong = $model->user_rating_loose_strong + $guestLooseStrong;
                    $model->user_rating_loose_super = $model->user_rating_loose_super + $guestLooseSuper;
                    $model->user_rating_loose_weak = $model->user_rating_loose_weak + $guestLooseWeak;
                    $model->user_rating_loose_overtime = $model->user_rating_loose_overtime + $guestLooseOvertime;
                    $model->user_rating_loose_overtime_equal = $model->user_rating_loose_overtime_equal + $guestLooseOvertimeEqual;
                    $model->user_rating_loose_overtime_strong = $model->user_rating_loose_overtime_strong + $guestLooseOvertimeStrong;
                    $model->user_rating_loose_overtime_weak = $model->user_rating_loose_overtime_weak + $guestLooseOvertimeWeak;
                    $model->user_rating_vs_super = $model->user_rating_vs_super + $guestVsSuper;
                    $model->user_rating_vs_rest = $model->user_rating_vs_rest + $guestVsRest;
                    $model->user_rating_win = $model->user_rating_win + $guestWin;
                    $model->user_rating_win_equal = $model->user_rating_win_equal + $guestWinEqual;
                    $model->user_rating_win_strong = $model->user_rating_win_strong + $guestWinStrong;
                    $model->user_rating_win_super = $model->user_rating_win_super + $guestWinSuper;
                    $model->user_rating_win_weak = $model->user_rating_win_weak + $guestWinWeak;
                    $model->user_rating_win_overtime = $model->user_rating_win_overtime + $guestWinOvertime;
                    $model->user_rating_win_overtime_equal = $model->user_rating_win_overtime_equal + $guestWinOvertimeEqual;
                    $model->user_rating_win_overtime_strong = $model->user_rating_win_overtime_strong + $guestWinOvertimeStrong;
                    $model->user_rating_win_overtime_weak = $model->user_rating_win_overtime_weak + $guestWinOvertimeWeak;
                    $model->save();
                }
            }

            if ($game->teamHome->team_user_id) {
                $model = UserRating::find()->where([
                    'user_rating_user_id' => $game->teamHome->team_user_id,
                    'user_rating_season_id' => $game->schedule->schedule_season_id,
                ])->limit(1)->one();

                if ($model) {
                    $model->user_rating_auto = $model->user_rating_auto + $homeAuto;
                    $model->user_rating_collision_loose = $model->user_rating_collision_loose + $homeCollisionLoose;
                    $model->user_rating_collision_win = $model->user_rating_collision_win + $homeCollisionWin;
                    $model->user_rating_game = $model->user_rating_game + 1;
                    $model->user_rating_loose = $model->user_rating_loose + $homeLoose;
                    $model->user_rating_loose_equal = $model->user_rating_loose_equal + $homeLooseEqual;
                    $model->user_rating_loose_strong = $model->user_rating_loose_strong + $homeLooseStrong;
                    $model->user_rating_loose_super = $model->user_rating_loose_super + $homeLooseSuper;
                    $model->user_rating_loose_weak = $model->user_rating_loose_weak + $homeLooseWeak;
                    $model->user_rating_loose_overtime = $model->user_rating_loose_overtime + $homeLooseOvertime;
                    $model->user_rating_loose_overtime_equal = $model->user_rating_loose_overtime_equal + $homeLooseOvertimeEqual;
                    $model->user_rating_loose_overtime_strong = $model->user_rating_loose_overtime_strong + $homeLooseOvertimeStrong;
                    $model->user_rating_loose_overtime_weak = $model->user_rating_loose_overtime_weak + $homeLooseOvertimeWeak;
                    $model->user_rating_vs_super = $model->user_rating_vs_super + $homeVsSuper;
                    $model->user_rating_vs_rest = $model->user_rating_vs_rest + $homeVsRest;
                    $model->user_rating_win = $model->user_rating_win + $homeWin;
                    $model->user_rating_win_equal = $model->user_rating_win_equal + $homeWinEqual;
                    $model->user_rating_win_strong = $model->user_rating_win_strong + $homeWinStrong;
                    $model->user_rating_win_super = $model->user_rating_win_super + $homeWinSuper;
                    $model->user_rating_win_weak = $model->user_rating_win_weak + $homeWinWeak;
                    $model->user_rating_win_overtime = $model->user_rating_win_overtime + $homeWinOvertime;
                    $model->user_rating_win_overtime_equal = $model->user_rating_win_overtime_equal + $homeWinOvertimeEqual;
                    $model->user_rating_win_overtime_strong = $model->user_rating_win_overtime_strong + $homeWinOvertimeStrong;
                    $model->user_rating_win_overtime_weak = $model->user_rating_win_overtime_weak + $homeWinOvertimeWeak;
                    $model->save();
                }
            }
        }
    }
}
