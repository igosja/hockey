<?php

namespace console\models\generator;

use common\models\Game;
use common\models\PlayerSpecial;
use common\models\Special;
use common\models\TournamentType;

/**
 * Class CountVisitor
 * @package console\models\generator
 */
class CountVisitor
{
    /**
     * @throws \Exception
     */
    public function execute()
    {
        $subQuery = Game::find()
            ->joinWith(['schedule'])
            ->select(['game_id'])
            ->where(['game_played' => 0])
            ->andWhere('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()');
        $specialArray = PlayerSpecial::find()
            ->indexBy('lineup.lineup_game_id')
            ->joinWith(['lineup'])
            ->select(['SUM(player_special_level) AS player_special_level', 'lineup_game_id'])
            ->where(['player_special_special_id' => Special::IDOL])
            ->andWhere(['lineup_game_id' => $subQuery])
            ->groupBy(['lineup_game_id'])
            ->all();

        $gameArray = Game::find()
            ->joinWith(['schedule'])
            ->with([
                'schedule',
                'nationalGuest',
                'nationalHome',
                'teamGuest',
                'teamHome',
                'stadium',
                'schedule.tournamentType',
                'schedule.stage',
            ])
            ->where(['game_played' => 0])
            ->andWhere('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->orderBy(['game_id' => SORT_ASC])
            ->each();
        foreach ($gameArray as $game) {
            /**
             * @var Game $game
             */
            $special = 0;
            if (isset($specialArray[$game->game_id])) {
                $special = $specialArray[$game->game_id]->playerspecial_level;
            }
            if (TournamentType::NATIONAL == $game->schedule->schedule_tournament_type_id) {
                $guestVisitor = $game->nationalGuest->national_visitor;
                $homeVisitor = $game->nationalHome->national_visitor;
            } else {
                $guestVisitor = $game->teamGuest->team_visitor;
                $homeVisitor = $game->teamHome->team_visitor;
            }

            $visitor = $game->stadium->stadium_capacity;
            $visitor = $visitor * $game->schedule->tournamentType->tournament_type_visitor;
            $visitor = $visitor * $game->schedule->stage->stage_visitor;
            $visitor = $visitor * (100 + $special * 5) / 100;

            $ticket = $game->game_ticket;
            if ($ticket < Game::TICKET_PRICE_MIN) {
                $ticket = Game::TICKET_PRICE_MIN;
            } elseif ($ticket > Game::TICKET_PRICE_MAX) {
                $ticket = Game::TICKET_PRICE_MAX;
            }

            $visitor = $visitor / pow(($ticket - Game::TICKET_PRICE_BASE) / 10, 1.1);

            if (in_array($game->schedule->schedule_tournament_type_id,
                [TournamentType::FRIENDLY, TournamentType::NATIONAL])) {
                $visitor = $visitor * ($homeVisitor + $guestVisitor) / 2;
            } else {
                $visitor = $visitor * ($homeVisitor * 2 + $guestVisitor) / 3;
            }

            $visitor = round($visitor / 1000000);

            if ($visitor > $game->stadium->stadium_capacity) {
                $visitor = $game->stadium->stadium_capacity;
            }

            $game->game_stadium_capacity = $game->stadium->stadium_capacity;
            $game->game_visitor = $visitor;
            $game->game_ticket = $ticket;
            $game->save();
        }
    }
}
