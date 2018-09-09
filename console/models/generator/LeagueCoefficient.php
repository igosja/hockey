<?php

namespace console\models\generator;

use common\models\Game;
use common\models\LeagueCoefficient as Model;
use common\models\Season;
use common\models\TournamentType;
use yii\db\Expression;

/**
 * Class LeagueCoefficient
 * @package console\models\generator
 */
class LeagueCoefficient
{
    /**
     * @return void
     */
    public function execute(): void
    {
        $gameArray = Game::find()
            ->joinWith(['schedule'])
            ->where(['game_played' => 0, 'schedule_tournament_type_id' => TournamentType::LEAGUE])
            ->andWhere('FROM_UNIXTIME(schedule_date, "%Y-%m-%d")=CURDATE()')
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
                } elseif ($game->game_guest_score_shootout == $game->game_home_score_shootout) {
                    $homeLooseShootout++;
                    $guestLooseShootout++;
                } else {
                    $homeWinShootout++;
                    $guestLooseShootout++;
                }
            }

            $model = Model::find()->where([
                'league_coefficient_team_id' => $game->game_home_team_id,
                'league_coefficient_season_id' => $game->schedule->schedule_season_id,
            ])->limit(1)->one();
            $model->league_coefficient_loose = $model->league_coefficient_loose + $homeLoose;
            $model->league_coefficient_loose_overtime = $model->league_coefficient_loose_overtime + $homeLooseOvertime;
            $model->league_coefficient_loose_shootout = $model->league_coefficient_loose_shootout + $homeLooseShootout;
            $model->league_coefficient_win = $model->league_coefficient_win + $homeWin;
            $model->league_coefficient_win_overtime = $model->league_coefficient_win_overtime + $homeWinOvertime;
            $model->league_coefficient_win_shootout = $model->league_coefficient_win_shootout + $homeWinShootout;
            $model->save();

            $model = Model::find()->where([
                'league_coefficient_team_id' => $game->game_guest_team_id,
                'league_coefficient_season_id' => $game->schedule->schedule_season_id,
            ])->limit(1)->one();
            $model->league_coefficient_loose = $model->league_coefficient_loose + $guestLoose;
            $model->league_coefficient_loose_overtime = $model->league_coefficient_loose_overtime + $guestLooseOvertime;
            $model->league_coefficient_loose_shootout = $model->league_coefficient_loose_shootout + $guestLooseShootout;
            $model->league_coefficient_win = $model->league_coefficient_win + $guestWin;
            $model->league_coefficient_win_overtime = $model->league_coefficient_win_overtime + $guestWinOvertime;
            $model->league_coefficient_win_shootout = $model->league_coefficient_win_shootout + $guestWinShootout;
            $model->save();
        }

        $expression = new Expression('
            league_coefficient_win * 3 +
            league_coefficient_win_overtime * 2 +
            league_coefficient_win_shootout * 2 +
            league_coefficient_loose_overtime +
            league_coefficient_loose_shootout
        ');
        Model::updateAll(
            ['league_coefficient_point' => $expression],
            ['league_coefficient_season_id' => Season::find()->max('season_id')]
        );
    }
}
