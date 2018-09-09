<?php

namespace console\models\generator;

use common\models\Game;
use common\models\TeamVisitor;
use common\models\TournamentType;

/**
 * Class TeamVisitorAfterGame
 * @package console\models\generator
 */
class TeamVisitorAfterGame
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
            ->andWhere(['!=', 'schedule_tournament_type_id', TournamentType::NATIONAL])
            ->orderBy(['game_id' => SORT_ASC])
            ->each();
        foreach ($gameArray as $game) {
            /**
             * @var Game $game
             */
            $homeScore = $game->game_home_score;
            if ($homeScore > 9) {
                $homeScore = 9;
            }

            $guestScore = $game->game_guest_score;
            if ($guestScore > 9) {
                $guestScore = 9;
            }

            $homeVisitor = 0.5 + $homeScore * 0.05 + 0.45 - $guestScore * 0.05;
            $guestVisitor = 0.5 + $guestScore * 0.05 + 0.45 - $homeScore * 0.05;

            $model = new TeamVisitor();
            $model->team_visitor_team_id = $game->game_home_team_id;
            $model->team_visitor_visitor = $homeVisitor;
            $model->save();

            $model = new TeamVisitor();
            $model->team_visitor_team_id = $game->game_guest_team_id;
            $model->team_visitor_visitor = $guestVisitor;
            $model->save();
        }
    }
}