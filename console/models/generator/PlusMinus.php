<?php

namespace console\models\generator;

use common\models\Game;
use common\models\History;
use common\models\HistoryText;
use common\models\Lineup;
use common\models\Mood;
use common\models\Schedule;
use common\models\TournamentType;
use yii\db\Expression;

/**
 * Class PlusMinus
 * @package console\models\generator
 *
 * @property Game $game
 */
class PlusMinus
{
    /**
     * @var Game $game
     */
    private $game;

    /**
     * @throws \Exception
     * @return void
     */
    public function execute()
    {
        $gameArray = Game::find()
            ->joinWith(['schedule'])
            ->with(['schedule'])
            ->where(['game_played' => 0])
            ->andWhere('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->orderBy(['game_id' => SORT_ASC])
            ->each(5);
        foreach ($gameArray as $game) {
            $this->game = $game;
            $guestCompetition = $this->competition();
            $guestMood = $this->mood('guest', 'home');
            $guestOptimality1 = $this->optimality1('guest');
            $guestOptimality2 = $this->optimality2('guest');
            $guestPower = $this->power('guest', 'home');
            $homeCompetition = $this->competition();
            $homeMood = $this->mood('home', 'guest');
            $homeOptimality1 = $this->optimality1('home');
            $homeOptimality2 = $this->optimality2('home');
            $homePower = $this->power('home', 'guest');
            list($guestScore, $homeScore) = $this->score();

            $guestTotal = $guestCompetition + $guestMood + $guestOptimality1 + $guestOptimality2 + $guestPower + $guestScore;

            if (substr($guestTotal * 10, -1)) {
                $guestTotal = $guestTotal + rand(0, 1) - 0.5;
            }

            if ($guestTotal > 5) {
                $guestTotal = 5;
            } elseif ($guestTotal < -5) {
                $guestTotal = -5;
            }

            $homeTotal = $homeCompetition + $homeMood + $homeOptimality1 + $homeOptimality2 + $homePower + $homeScore;

            if (substr($homeTotal * 10, -1)) {
                $homeTotal = $homeTotal + rand(0, 1) - 0.5;
            }

            if ($homeTotal > 5) {
                $homeTotal = 5;
            } elseif ($homeTotal < -5) {
                $homeTotal = -5;
            }

            if (TournamentType::NATIONAL == $this->game->schedule->schedule_tournament_type_id) {
                if ($homeTotal < 0) {
                    $homeTotal = 0;
                }

                if ($guestTotal < 0) {
                    $guestTotal = 0;
                }
            }

            $this->game->game_guest_plus_minus = $guestTotal;
            $this->game->game_guest_plus_minus_competition = $guestCompetition;
            $this->game->game_guest_plus_minus_mood = $guestMood;
            $this->game->game_guest_plus_minus_optimality_1 = $guestOptimality1;
            $this->game->game_guest_plus_minus_optimality_2 = $guestOptimality2;
            $this->game->game_guest_plus_minus_power = $guestPower;
            $this->game->game_guest_plus_minus_score = $guestScore;
            $this->game->game_home_plus_minus = $homeTotal;
            $this->game->game_home_plus_minus_competition = $homeCompetition;
            $this->game->game_home_plus_minus_mood = $homeMood;
            $this->game->game_home_plus_minus_optimality_1 = $homeOptimality1;
            $this->game->game_home_plus_minus_optimality_2 = $homeOptimality2;
            $this->game->game_home_plus_minus_power = $homePower;
            $this->game->game_home_plus_minus_score = $homeScore;
            $this->game->save();
        }

        $subQuery = Schedule::find()
            ->select(['schedule_id'])
            ->where('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()');

        Game::updateAll(
            ['game_guest_plus_minus' => new Expression('FLOOR(`game_guest_plus_minus`)+ROUND(RAND())')],
            ['and', 'CEIL(`game_guest_plus_minus`)!=`game_guest_plus_minus`', ['game_schedule_id' => $subQuery]]
        );
        Game::updateAll(
            ['game_home_plus_minus' => new Expression('FLOOR(`game_home_plus_minus`)+ROUND(RAND())')],
            ['and', 'CEIL(`game_home_plus_minus`)!=`game_home_plus_minus`', ['game_schedule_id' => $subQuery]]
        );

        $gameArray = Game::find()
            ->joinWith(['schedule'])
            ->where(['game_played' => 0])
            ->andWhere('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->orderBy(['game_id' => SORT_ASC])
            ->each(5);
        foreach ($gameArray as $game) {
            $this->game = $game;

            if ($this->game->game_home_plus_minus < 0) {
                $lineupArray = Lineup::find()
                    ->joinWith(['player'])
                    ->where([
                        'lineup_team_id' => $this->game->game_home_team_id,
                        'lineup_national_id' => $this->game->game_home_national_id,
                        'lineup_game_id' => $this->game->game_id,
                    ])
                    ->andWhere('`lineup_id` NOT IN (
                        SELECT `lineup_id`
                        FROM `lineup`
                        LEFT JOIN `game`
                        ON `lineup_game_id`=`game_id`
                        LEFT JOIN `schedule`
                        ON `game_schedule_id`=`schedule_id`
                        WHERE FROM_UNIXTIME(`schedule_date`, \'%Y-%m-%d\')=CURDATE()
                        AND `lineup_line_id`=1
                        AND `lineup_position_id`=1
                    )')
                    ->andWhere(['!=', 'player_team_id', 0])
                    ->orderBy('RAND()')
                    ->limit(-$this->game->game_home_plus_minus)
                    ->all();
                foreach ($lineupArray as $lineup) {
                    $lineup->player->player_power_nominal = $lineup->player->player_power_nominal - 1;
                    $lineup->player->save();

                    $lineup->lineup_power_change = -1;
                    $lineup->save();

                    History::log([
                        'history_game_id' => $this->game->game_id,
                        'history_history_text_id' => HistoryText::PLAYER_GAME_POINT_MINUS,
                        'history_player_id' => $lineup->lineup_player_id,
                    ]);
                }
            } elseif ($this->game->game_home_plus_minus > 0) {
                $lineupArray = Lineup::find()
                    ->joinWith(['player'])
                    ->where([
                        'lineup_team_id' => $this->game->game_home_team_id,
                        'lineup_national_id' => $this->game->game_home_national_id,
                        'lineup_game_id' => $this->game->game_id,
                    ])
                    ->andWhere('`lineup_id` NOT IN (
                        SELECT `lineup_id`
                        FROM `lineup`
                        LEFT JOIN `game`
                        ON `lineup_game_id`=`game_id`
                        LEFT JOIN `schedule`
                        ON `game_schedule_id`=`schedule_id`
                        WHERE FROM_UNIXTIME(`schedule_date`, \'%Y-%m-%d\')=CURDATE()
                        AND `lineup_line_id`=1
                        AND `lineup_position_id`=1
                    )')
                    ->andWhere(['!=', 'player_team_id', 0])
                    ->orderBy('RAND()')
                    ->limit($this->game->game_home_plus_minus)
                    ->all();
                foreach ($lineupArray as $lineup) {
                    $lineup->player->player_power_nominal = $lineup->player->player_power_nominal + 1;
                    $lineup->player->save();

                    $lineup->lineup_power_change = 1;
                    $lineup->save();

                    History::log([
                        'history_game_id' => $this->game->game_id,
                        'history_history_text_id' => HistoryText::PLAYER_GAME_POINT_PLUS,
                        'history_player_id' => $lineup->lineup_player_id,
                    ]);
                }
            }

            if ($this->game->game_guest_plus_minus < 0) {
                $lineupArray = Lineup::find()
                    ->joinWith(['player'])
                    ->where([
                        'lineup_team_id' => $this->game->game_guest_team_id,
                        'lineup_national_id' => $this->game->game_guest_national_id,
                        'lineup_game_id' => $this->game->game_id,
                    ])
                    ->andWhere('`lineup_id` NOT IN (
                        SELECT `lineup_id`
                        FROM `lineup`
                        LEFT JOIN `game`
                        ON `lineup_game_id`=`game_id`
                        LEFT JOIN `schedule`
                        ON `game_schedule_id`=`schedule_id`
                        WHERE FROM_UNIXTIME(`schedule_date`, \'%Y-%m-%d\')=CURDATE()
                        AND `lineup_line_id`=1
                        AND `lineup_position_id`=1
                    )')
                    ->andWhere(['!=', 'player_team_id', 0])
                    ->orderBy('RAND()')
                    ->limit(-$this->game->game_guest_plus_minus)
                    ->all();
                foreach ($lineupArray as $lineup) {
                    $lineup->player->player_power_nominal = $lineup->player->player_power_nominal - 1;
                    $lineup->player->save();

                    $lineup->lineup_power_change = -1;
                    $lineup->save();

                    History::log([
                        'history_game_id' => $this->game->game_id,
                        'history_history_text_id' => HistoryText::PLAYER_GAME_POINT_MINUS,
                        'history_player_id' => $lineup->lineup_player_id,
                    ]);
                }
            } elseif ($this->game->game_guest_plus_minus > 0) {
                $lineupArray = Lineup::find()
                    ->joinWith(['player'])
                    ->where([
                        'lineup_team_id' => $this->game->game_guest_team_id,
                        'lineup_national_id' => $this->game->game_guest_national_id,
                        'lineup_game_id' => $this->game->game_id,
                    ])
                    ->andWhere('`lineup_id` NOT IN (
                        SELECT `lineup_id`
                        FROM `lineup`
                        LEFT JOIN `game`
                        ON `lineup_game_id`=`game_id`
                        LEFT JOIN `schedule`
                        ON `game_schedule_id`=`schedule_id`
                        WHERE FROM_UNIXTIME(`schedule_date`, \'%Y-%m-%d\')=CURDATE()
                        AND `lineup_line_id`=1
                        AND `lineup_position_id`=1
                    )')
                    ->andWhere(['!=', 'player_team_id', 0])
                    ->orderBy('RAND()')
                    ->limit($this->game->game_guest_plus_minus)
                    ->all();
                foreach ($lineupArray as $lineup) {
                    $lineup->player->player_power_nominal = $lineup->player->player_power_nominal + 1;
                    $lineup->player->save();

                    $lineup->lineup_power_change = 1;
                    $lineup->save();

                    History::log([
                        'history_game_id' => $this->game->game_id,
                        'history_history_text_id' => HistoryText::PLAYER_GAME_POINT_PLUS,
                        'history_player_id' => $lineup->lineup_player_id,
                    ]);
                }
            }
        }
    }

    /**
     * @return float
     */
    protected function competition()
    {
        if (TournamentType::NATIONAL == $this->game->schedule->schedule_tournament_type_id) {
            $result = 2.5;
        } elseif (TournamentType::LEAGUE == $this->game->schedule->schedule_tournament_type_id) {
            $result = 2.0;
        } else {
            $result = 0.0;
        }

        return $result;
    }

    /**
     * @param string $team
     * @param string $opponent
     * @return float
     */
    protected function mood($team, $opponent)
    {
        $teamMood = 'game_' . $team . '_mood_id';
        $opponentMood = 'game_' . $opponent . '_mood_id';

        $result = 0;

        if (Mood::SUPER == $this->game->$teamMood) {
            $result = $result - 1;
        } elseif (Mood::REST == $this->game->$teamMood) {
            $result = $result + 0.5;
        }

        if (Mood::SUPER == $this->game->$opponentMood) {
            $result = $result + 0.5;
        } elseif (Mood::REST == $this->game->$opponentMood) {
            $result = $result - 1;
        }

        return $result;
    }

    /**
     * @param string $team
     * @return float
     */
    protected function optimality1($team)
    {
        $optimality = 'game_' . $team . '_optimality_1';

        if ($this->game->$optimality > 99) {
            $result = 0.5;
        } elseif ($this->game->$optimality > 96) {
            $result = 0;
        } elseif ($this->game->$optimality > 93) {
            $result = -0.5;
        } elseif ($this->game->$optimality > 90) {
            $result = -1;
        } elseif ($this->game->$optimality > 87) {
            $result = -1.5;
        } elseif ($this->game->$optimality > 84) {
            $result = -2;
        } elseif ($this->game->$optimality > 81) {
            $result = -2.5;
        } elseif ($this->game->$optimality > 78) {
            $result = -3;
        } elseif ($this->game->$optimality > 75) {
            $result = -3.5;
        } elseif ($this->game->$optimality > 72) {
            $result = -4;
        } else {
            $result = -4.5;
        }

        return $result;
    }

    /**
     * @param string $team
     * @return float
     */
    protected function optimality2($team)
    {
        $optimality = 'game_' . $team . '_optimality_2';

        if ($this->game->$optimality > 134) {
            $result = 2.5;
        } elseif ($this->game->$optimality > 124) {
            $result = 2;
        } elseif ($this->game->$optimality > 114) {
            $result = 1.5;
        } elseif ($this->game->$optimality > 109) {
            $result = 1;
        } elseif ($this->game->$optimality > 104) {
            $result = 0.5;
        } elseif ($this->game->$optimality > 49) {
            $result = 0;
        } elseif ($this->game->$optimality > 45) {
            $result = -0.5;
        } elseif ($this->game->$optimality > 42) {
            $result = -1;
        } elseif ($this->game->$optimality > 39) {
            $result = -1.5;
        } elseif ($this->game->$optimality > 36) {
            $result = -2;
        } elseif ($this->game->$optimality > 34) {
            $result = -2.5;
        } elseif ($this->game->$optimality > 32) {
            $result = -3;
        } elseif ($this->game->$optimality > 30) {
            $result = -3.5;
        } elseif ($this->game->$optimality > 28) {
            $result = -4;
        } elseif ($this->game->$optimality > 26) {
            $result = -4.5;
        } else {
            $result = -5;
        }

        return $result;
    }

    /**
     * @param string $team
     * @param string $opponent
     * @return float
     */
    private function power($team, $opponent)
    {
        $percent = 'game_' . $team . '_power_percent';
        $teamScore = 'game_' . $team . '_score';
        $opponentScore = 'game_' . $opponent . '_score';

        if ($this->game->$percent > 74) {
            if ($this->game->$teamScore > $this->game->$opponentScore) {
                $result = -3.5;
            } elseif ($this->game->$teamScore == $this->game->$opponentScore) {
                $result = -4;
            } else {
                $result = -4.5;
            }
        } elseif ($this->game->$percent > 70) {
            if ($this->game->$teamScore > $this->game->$opponentScore) {
                $result = -3;
            } elseif ($this->game->$teamScore == $this->game->$opponentScore) {
                $result = -3.5;
            } else {
                $result = -4;
            }
        } elseif ($this->game->$percent > 67) {
            if ($this->game->$teamScore > $this->game->$opponentScore) {
                $result = -2.5;
            } elseif ($this->game->$teamScore == $this->game->$opponentScore) {
                $result = -3;
            } else {
                $result = -3.5;
            }
        } elseif ($this->game->$percent > 64) {
            if ($this->game->$teamScore > $this->game->$opponentScore) {
                $result = -2;
            } elseif ($this->game->$teamScore == $this->game->$opponentScore) {
                $result = -2.5;
            } else {
                $result = -3;
            }
        } elseif ($this->game->$percent > 61) {
            if ($this->game->$teamScore > $this->game->$opponentScore) {
                $result = -1.5;
            } elseif ($this->game->$teamScore == $this->game->$opponentScore) {
                $result = -2;
            } else {
                $result = -2.5;
            }
        } elseif ($this->game->$percent > 58) {
            if ($this->game->$teamScore > $this->game->$opponentScore) {
                $result = -1;
            } elseif ($this->game->$teamScore == $this->game->$opponentScore) {
                $result = -1.5;
            } else {
                $result = -2;
            }
        } elseif ($this->game->$percent > 56) {
            if ($this->game->$teamScore > $this->game->$opponentScore) {
                $result = -0.5;
            } elseif ($this->game->$teamScore == $this->game->$opponentScore) {
                $result = -1;
            } else {
                $result = -1.5;
            }
        } elseif ($this->game->$percent > 54) {
            if ($this->game->$teamScore > $this->game->$opponentScore) {
                $result = 0;
            } elseif ($this->game->$teamScore == $this->game->$opponentScore) {
                $result = -0.5;
            } else {
                $result = -1;
            }
        } elseif ($this->game->$percent > 52) {
            if ($this->game->$teamScore > $this->game->$opponentScore) {
                $result = 0.5;
            } elseif ($this->game->$teamScore == $this->game->$opponentScore) {
                $result = 0;
            } else {
                $result = -0.5;
            }
        } elseif ($this->game->$percent > 50) {
            if ($this->game->$teamScore > $this->game->$opponentScore) {
                $result = 1;
            } elseif ($this->game->$teamScore == $this->game->$opponentScore) {
                $result = 0.5;
            } else {
                $result = 0;
            }
        } elseif ($this->game->$percent > 48) {
            if ($this->game->$teamScore > $this->game->$opponentScore) {
                $result = 1.5;
            } elseif ($this->game->$teamScore == $this->game->$opponentScore) {
                $result = 1;
            } else {
                $result = 0.5;
            }
        } elseif ($this->game->$percent > 46) {
            if ($this->game->$teamScore > $this->game->$opponentScore) {
                $result = 2;
            } elseif ($this->game->$teamScore == $this->game->$opponentScore) {
                $result = 1.5;
            } else {
                $result = 1;
            }
        } elseif ($this->game->$percent > 44) {
            if ($this->game->$teamScore > $this->game->$opponentScore) {
                $result = 2.5;
            } elseif ($this->game->$teamScore == $this->game->$opponentScore) {
                $result = 2;
            } else {
                $result = 1.5;
            }
        } elseif ($this->game->$percent > 42) {
            if ($this->game->$teamScore > $this->game->$opponentScore) {
                $result = 3;
            } elseif ($this->game->$teamScore == $this->game->$opponentScore) {
                $result = 2.5;
            } else {
                $result = 2;
            }
        } elseif ($this->game->$percent > 40) {
            if ($this->game->$teamScore > $this->game->$opponentScore) {
                $result = 3.5;
            } elseif ($this->game->$teamScore == $this->game->$opponentScore) {
                $result = 3;
            } else {
                $result = 2.5;
            }
        } elseif ($this->game->$percent > 37) {
            if ($this->game->$teamScore > $this->game->$opponentScore) {
                $result = 4;
            } elseif ($this->game->$teamScore == $this->game->$opponentScore) {
                $result = 3.5;
            } else {
                $result = 3;
            }
        } elseif ($this->game->$percent > 34) {
            if ($this->game->$teamScore > $this->game->$opponentScore) {
                $result = 4.5;
            } elseif ($this->game->$teamScore == $this->game->$opponentScore) {
                $result = 4;
            } else {
                $result = 3.5;
            }
        } elseif ($this->game->$percent > 31) {
            if ($this->game->$teamScore > $this->game->$opponentScore) {
                $result = 5;
            } elseif ($this->game->$teamScore == $this->game->$opponentScore) {
                $result = 4.5;
            } else {
                $result = 4;
            }
        } elseif ($this->game->$percent > 28) {
            if ($this->game->$teamScore > $this->game->$opponentScore) {
                $result = 5.5;
            } elseif ($this->game->$teamScore == $this->game->$opponentScore) {
                $result = 5;
            } else {
                $result = 4.5;
            }
        } elseif ($this->game->$percent > 24) {
            if ($this->game->$teamScore > $this->game->$opponentScore) {
                $result = 6;
            } elseif ($this->game->$teamScore == $this->game->$opponentScore) {
                $result = 5.5;
            } else {
                $result = 5;
            }
        } else {
            if ($this->game->$teamScore > $this->game->$opponentScore) {
                $result = 6.5;
            } elseif ($this->game->$teamScore == $this->game->$opponentScore) {
                $result = 6;
            } else {
                $result = 5.5;
            }
        }

        return $result;
    }

    /**
     * @return array
     */
    protected function score()
    {
        $guestScore = 0;
        $homeScore = 0;

        if ($this->game->game_guest_score - $this->game->game_home_score > 8) {
            $guestScore = 8.5;
            $homeScore = -6.5;
        } elseif ($this->game->game_guest_score - $this->game->game_home_score > 7) {
            $guestScore = 7.5;
            $homeScore = -5.5;
        } elseif ($this->game->game_guest_score - $this->game->game_home_score > 6) {
            $guestScore = 6.5;
            $homeScore = -4.5;
        } elseif ($this->game->game_guest_score - $this->game->game_home_score > 5) {
            $guestScore = 5.5;
            $homeScore = -3.5;
        } elseif ($this->game->game_guest_score - $this->game->game_home_score > 4) {
            $guestScore = 4.5;
            $homeScore = -2.5;
        } elseif ($this->game->game_guest_score - $this->game->game_home_score > 3) {
            $guestScore = 3.5;
            $homeScore = -1.5;
        } elseif ($this->game->game_guest_score - $this->game->game_home_score > 2) {
            $guestScore = 2.5;
            $homeScore = -0.5;
        } elseif ($this->game->game_guest_score - $this->game->game_home_score > 1) {
            $guestScore = 1.5;
            $homeScore = 0;
        } elseif ($this->game->game_guest_score - $this->game->game_home_score > 0) {
            $guestScore = 0.5;
            $homeScore = 0;
        }

        if ($this->game->game_home_score - $this->game->game_guest_score > 8) {
            $homeScore = 8.5;
            $guestScore = -6.5;
        } elseif ($this->game->game_home_score - $this->game->game_guest_score > 7) {
            $homeScore = 7.5;
            $guestScore = -5.5;
        } elseif ($this->game->game_home_score - $this->game->game_guest_score > 6) {
            $homeScore = 6.5;
            $guestScore = -4.5;
        } elseif ($this->game->game_home_score - $this->game->game_guest_score > 5) {
            $homeScore = 5.5;
            $guestScore = -3.5;
        } elseif ($this->game->game_home_score - $this->game->game_guest_score > 4) {
            $homeScore = 4.5;
            $guestScore = -2.5;
        } elseif ($this->game->game_home_score - $this->game->game_guest_score > 3) {
            $homeScore = 3.5;
            $guestScore = -1.5;
        } elseif ($this->game->game_home_score - $this->game->game_guest_score > 2) {
            $homeScore = 2.5;
            $guestScore = -0.5;
        } elseif ($this->game->game_home_score - $this->game->game_guest_score > 1) {
            $homeScore = 1.5;
            $guestScore = 0;
        } elseif ($this->game->game_home_score - $this->game->game_guest_score > 0) {
            $homeScore = 0.5;
            $guestScore = 0;
        }

        return [$guestScore, $homeScore];
    }
}
