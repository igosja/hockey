<?php

namespace console\models\generator;

use common\models\Championship;
use common\models\Conference;
use common\models\Game;
use common\models\League;
use common\models\OffSeason;
use common\models\Season;
use common\models\Stage;
use common\models\TournamentType;
use common\models\WorldCup;
use yii\db\Expression;

/**
 * Class Standing
 * @package console\models\generator
 */
class Standing
{
    /**
     * @return void
     */
    public function execute(): void
    {
        $gameArray = Game::find()
            ->joinWith(['schedule'])
            ->where(['game_played' => 0])
            ->andWhere('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->orderBy(['game_id' => SORT_ASC])
            ->each();
        foreach ($gameArray as $game) {
            /**
             * @var Game $game
             */
            $guestLoose = 0;
            $guestLooseShootout = 0;
            $guestLooseOvertime = 0;
            $guestWin = 0;
            $guestWinShootout = 0;
            $guestWinOvertime = 0;
            $homeLoose = 0;
            $homeLooseShootout = 0;
            $homeLooseOvertime = 0;
            $homeWin = 0;
            $homeWinShootout = 0;
            $homeWinOvertime = 0;

            if ($game->game_home_score > $game->game_guest_score) {
                if (0 == $game->game_home_score_overtime) {
                    $homeWin++;
                    $guestLoose++;
                } else {
                    $homeWinOvertime++;
                    $guestLooseOvertime++;
                }
            } elseif ($game->game_guest_score > $game->game_home_score) {
                if (0 == $game->game_guest_score_overtime) {
                    $guestWin++;
                    $homeLoose++;
                } else {
                    $guestWinOvertime++;
                    $homeLooseOvertime++;
                }
            } elseif ($game->game_guest_score == $game->game_home_score) {
                if ($game->game_guest_score_shootout > $game->game_home_score_shootout) {
                    $guestWinShootout++;
                    $homeLooseShootout++;
                } else {
                    $homeWinShootout++;
                    $guestLooseShootout++;
                }
            }

            if (TournamentType::CONFERENCE == $game->schedule->schedule_tournament_type_id) {
                $model = Conference::find()->where([
                    'conference_team_id' => $game->game_home_team_id,
                    'conference_season_id' => $game->schedule->schedule_season_id,
                ])->one();
                if ($model) {
                    $model->conference_game = $model->conference_game + 1;
                    $model->conference_home = $model->conference_home + 1;
                    $model->conference_loose = $model->conference_loose + $homeLoose;
                    $model->conference_loose_shootout = $model->conference_loose_shootout + $homeLooseShootout;
                    $model->conference_loose_overtime = $model->conference_loose_overtime + $homeLooseOvertime;
                    $model->conference_pass = $model->conference_pass + $game->game_guest_score;
                    $model->conference_score = $model->conference_score + $game->game_home_score;
                    $model->conference_win = $model->conference_win + $homeWin;
                    $model->conference_win_shootout = $model->conference_win_shootout + $homeWinShootout;
                    $model->conference_win_overtime = $model->conference_win_overtime + $homeWinOvertime;
                    $model->save();
                }

                $model = Conference::find()->where([
                    'conference_team_id' => $game->game_guest_team_id,
                    'conference_season_id' => $game->schedule->schedule_season_id,
                ])->one();
                if ($model) {
                    $model->conference_game = $model->conference_game + 1;
                    $model->conference_guest = $model->conference_guest + 1;
                    $model->conference_loose = $model->conference_loose + $guestLoose;
                    $model->conference_loose_shootout = $model->conference_loose_shootout + $guestLooseShootout;
                    $model->conference_loose_overtime = $model->conference_loose_overtime + $guestLooseOvertime;
                    $model->conference_pass = $model->conference_pass + $game->game_home_score;
                    $model->conference_score = $model->conference_score + $game->game_guest_score;
                    $model->conference_win = $model->conference_win + $guestWin;
                    $model->conference_win_shootout = $model->conference_win_shootout + $guestWinShootout;
                    $model->conference_win_overtime = $model->conference_win_overtime + $guestWinOvertime;
                    $model->save();
                }
            } elseif (TournamentType::OFF_SEASON == $game->schedule->schedule_tournament_type_id) {
                $model = OffSeason::find()->where([
                    'off_season_team_id' => $game->game_home_team_id,
                    'off_season_season_id' => $game->schedule->schedule_season_id,
                ])->one();
                if ($model) {
                    $model->off_season_game = $model->off_season_game + 1;
                    $model->off_season_home = $model->off_season_home + 1;
                    $model->off_season_loose = $model->off_season_loose + $homeLoose;
                    $model->off_season_loose_shootout = $model->off_season_loose_shootout + $homeLooseShootout;
                    $model->off_season_loose_overtime = $model->off_season_loose_overtime + $homeLooseOvertime;
                    $model->off_season_pass = $model->off_season_pass + $game->game_guest_score;
                    $model->off_season_score = $model->off_season_score + $game->game_home_score;
                    $model->off_season_win = $model->off_season_win + $homeWin;
                    $model->off_season_win_shootout = $model->off_season_win_shootout + $homeWinShootout;
                    $model->off_season_win_overtime = $model->off_season_win_overtime + $homeWinOvertime;
                    $model->save();
                }

                $model = OffSeason::find()->where([
                    'off_season_team_id' => $game->game_guest_team_id,
                    'off_season_season_id' => $game->schedule->schedule_season_id,
                ])->one();
                if ($model) {
                    $model->off_season_game = $model->off_season_game + 1;
                    $model->off_season_guest = $model->off_season_guest + 1;
                    $model->off_season_loose = $model->off_season_loose + $guestLoose;
                    $model->off_season_loose_shootout = $model->off_season_loose_shootout + $guestLooseShootout;
                    $model->off_season_loose_overtime = $model->off_season_loose_overtime + $guestLooseOvertime;
                    $model->off_season_pass = $model->off_season_pass + $game->game_home_score;
                    $model->off_season_score = $model->off_season_score + $game->game_guest_score;
                    $model->off_season_win = $model->off_season_win + $guestWin;
                    $model->off_season_win_shootout = $model->off_season_win_shootout + $guestWinShootout;
                    $model->off_season_win_overtime = $model->off_season_win_overtime + $guestWinOvertime;
                    $model->save();
                }
            } elseif (TournamentType::CHAMPIONSHIP == $game->schedule->schedule_tournament_type_id &&
                $game->schedule->schedule_stage_id >= Stage::TOUR_1 &&
                $game->schedule->schedule_stage_id <= Stage::TOUR_30) {
                $model = Championship::find()->where([
                    'championship_team_id' => $game->game_home_team_id,
                    'championship_season_id' => $game->schedule->schedule_season_id,
                ])->one();
                if ($model) {
                    $model->championship_game = $model->championship_game + 1;
                    $model->championship_loose = $model->championship_loose + $homeLoose;
                    $model->championship_loose_shootout = $model->championship_loose_shootout + $homeLooseShootout;
                    $model->championship_loose_overtime = $model->championship_loose_overtime + $homeLooseOvertime;
                    $model->championship_pass = $model->championship_pass + $game->game_guest_score;
                    $model->championship_score = $model->championship_score + $game->game_home_score;
                    $model->championship_win = $model->championship_win + $homeWin;
                    $model->championship_win_shootout = $model->championship_win_shootout + $homeWinShootout;
                    $model->championship_win_overtime = $model->championship_win_overtime + $homeWinOvertime;
                    $model->save();
                }

                $model = Championship::find()->where([
                    'championship_team_id' => $game->game_guest_team_id,
                    'championship_season_id' => $game->schedule->schedule_season_id,
                ])->one();
                if ($model) {
                    $model->championship_game = $model->championship_game + 1;
                    $model->championship_loose = $model->championship_loose + $guestLoose;
                    $model->championship_loose_shootout = $model->championship_loose_shootout + $guestLooseShootout;
                    $model->championship_loose_overtime = $model->championship_loose_overtime + $guestLooseOvertime;
                    $model->championship_pass = $model->championship_pass + $game->game_home_score;
                    $model->championship_score = $model->championship_score + $game->game_guest_score;
                    $model->championship_win = $model->championship_win + $guestWin;
                    $model->championship_win_shootout = $model->championship_win_shootout + $guestWinShootout;
                    $model->championship_win_overtime = $model->championship_win_overtime + $guestWinOvertime;
                    $model->save();
                }
            } elseif (TournamentType::LEAGUE == $game->schedule->schedule_tournament_type_id &&
                $game->schedule->schedule_stage_id >= Stage::TOUR_LEAGUE_1 &&
                $game->schedule->schedule_stage_id <= Stage::TOUR_LEAGUE_6) {
                $model = League::find()->where([
                    'league_team_id' => $game->game_home_team_id,
                    'league_season_id' => $game->schedule->schedule_season_id,
                ])->one();
                if ($model) {
                    $model->league_game = $model->league_game + 1;
                    $model->league_loose = $model->league_loose + $homeLoose;
                    $model->league_loose_shootout = $model->league_loose_shootout + $homeLooseShootout;
                    $model->league_loose_overtime = $model->league_loose_overtime + $homeLooseOvertime;
                    $model->league_pass = $model->league_pass + $game->game_guest_score;
                    $model->league_score = $model->league_score + $game->game_home_score;
                    $model->league_win = $model->league_win + $homeWin;
                    $model->league_win_shootout = $model->league_win_shootout + $homeWinShootout;
                    $model->league_win_overtime = $model->league_win_overtime + $homeWinOvertime;
                    $model->save();
                }

                $model = League::find()->where([
                    'league_team_id' => $game->game_guest_team_id,
                    'league_season_id' => $game->schedule->schedule_season_id,
                ])->one();
                if ($model) {
                    $model->league_game = $model->league_game + 1;
                    $model->league_loose = $model->league_loose + $guestLoose;
                    $model->league_loose_shootout = $model->league_loose_shootout + $guestLooseShootout;
                    $model->league_loose_overtime = $model->league_loose_overtime + $guestLooseOvertime;
                    $model->league_pass = $model->league_pass + $game->game_home_score;
                    $model->league_score = $model->league_score + $game->game_guest_score;
                    $model->league_win = $model->league_win + $guestWin;
                    $model->league_win_shootout = $model->league_win_shootout + $guestWinShootout;
                    $model->league_win_overtime = $model->league_win_overtime + $guestWinOvertime;
                    $model->save();
                }
            } elseif (TournamentType::NATIONAL == $game->schedule->schedule_tournament_type_id) {
                $model = WorldCup::find()->where([
                    'world_cup_national_id' => $game->game_home_national_id,
                    'world_cup_season_id' => $game->schedule->schedule_season_id,
                ])->one();
                if ($model) {
                    $model->world_cup_game = $model->world_cup_game + 1;
                    $model->world_cup_loose = $model->world_cup_loose + $homeLoose;
                    $model->world_cup_loose_shootout = $model->world_cup_loose_shootout + $homeLooseShootout;
                    $model->world_cup_loose_overtime = $model->world_cup_loose_overtime + $homeLooseOvertime;
                    $model->world_cup_pass = $model->world_cup_pass + $game->game_guest_score;
                    $model->world_cup_score = $model->world_cup_score + $game->game_home_score;
                    $model->world_cup_win = $model->world_cup_win + $homeWin;
                    $model->world_cup_win_shootout = $model->world_cup_win_shootout + $homeWinShootout;
                    $model->world_cup_win_overtime = $model->world_cup_win_overtime + $homeWinOvertime;
                    $model->save();
                }

                $model = WorldCup::find()->where([
                    'world_cup_national_id' => $game->game_home_national_id,
                    'world_cup_season_id' => $game->schedule->schedule_season_id,
                ])->one();
                if ($model) {
                    $model->world_cup_game = $model->world_cup_game + 1;
                    $model->world_cup_loose = $model->world_cup_loose + $guestLoose;
                    $model->world_cup_loose_shootout = $model->world_cup_loose_shootout + $guestLooseShootout;
                    $model->world_cup_loose_overtime = $model->world_cup_loose_overtime + $guestLooseOvertime;
                    $model->world_cup_pass = $model->world_cup_pass + $game->game_home_score;
                    $model->world_cup_score = $model->world_cup_score + $game->game_guest_score;
                    $model->world_cup_win = $model->world_cup_win + $guestWin;
                    $model->world_cup_win_shootout = $model->world_cup_win_shootout + $guestWinShootout;
                    $model->world_cup_win_overtime = $model->world_cup_win_overtime + $guestWinOvertime;
                    $model->save();
                }
            }
        }

        $seasonId = Season::getCurrentSeason();

        WorldCup::updateAll([
            'world_cup_point' => new Expression('
                world_cup_win * 3 + 
                world_cup_win_overtime * 2 +
                world_cup_win_shootout * 2 +
                world_cup_loose_overtime +
                world_cup_loose_shootout
            '),
            'world_cup_difference' => new Expression('world_cup_score-world_cup_pass')
        ], ['world_cup_season_id' => $seasonId]);

        League::updateAll([
            'league_point' => new Expression('
                league_win * 3 + 
                league_win_overtime * 2 +
                league_win_shootout * 2 +
                league_loose_overtime +
                league_loose_shootout
            '),
            'league_difference' => new Expression('league_score-league_pass')
        ], ['league_season_id' => $seasonId]);

        Championship::updateAll([
            'championship_point' => new Expression('
                championship_win * 3 + 
                championship_win_overtime * 2 +
                championship_win_shootout * 2 +
                championship_loose_overtime +
                championship_loose_shootout
            '),
            'championship_difference' => new Expression('championship_score-championship_pass')
        ], ['championship_season_id' => $seasonId]);

        Conference::updateAll([
            'conference_point' => new Expression('
                conference_win * 3 + 
                conference_win_overtime * 2 +
                conference_win_shootout * 2 +
                conference_loose_overtime +
                conference_loose_shootout
            '),
            'conference_difference' => new Expression('conference_score-conference_pass')
        ], ['conference_season_id' => $seasonId]);

        OffSeason::updateAll([
            'off_season_point' => new Expression('
                off_season_win * 3 + 
                off_season_win_overtime * 2 +
                off_season_win_shootout * 2 +
                off_season_loose_overtime +
                off_season_loose_shootout
            '),
            'off_season_difference' => new Expression('off_season_score-off_season_pass')
        ], ['off_season_season_id' => $seasonId]);
    }
}
