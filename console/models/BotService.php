<?php

namespace console\models;

use common\models\Game;
use common\models\Lineup;
use common\models\Player;
use common\models\Position;
use common\models\Site;
use common\models\Team;
use Exception;

/**
 * Class BotService
 * @package console\models\generator
 */
class BotService
{
    /**
     * @throws Exception
     */
    public function execute()
    {
        if (!Site::status()) {
            return;
        }
        $this->lineup();
    }

    /**
     * @throws Exception
     */
    private function lineup()
    {
        $team = Team::find()
            ->where(['team_user_id' => 0])
            ->orderBy('RAND()')
            ->limit(1)
            ->one();
        $game = Game::find()
            ->joinWith(['schedule'], false)
            ->where([
                'or',
                ['game_guest_team_id' => $team->team_id],
                ['game_home_team_id' => $team->team_id],
            ])
            ->andWhere(['game_played' => 0])
            ->orderBy(['schedule_date' => SORT_ASC])
            ->limit(1)
            ->one();
        if (!$game) {
            return;
        }

        $countLineup = Lineup::find()
            ->where([
                'lineup_team_id' => $team->team_id,
                'lineup_game_id' => $game->game_id,
            ])
            ->count();

        if ($game->game_home_team_id == $team->team_id && 22 == $countLineup) {
            return;
        }

        if ($game->game_guest_team_id == $team->team_id && 22 == $countLineup) {
            return;
        }

        Lineup::deleteAll(['lineup_game_id' => $game->game_id, 'lineup_team_id' => $team->team_id]);

        $playerArray = Player::find()
            ->where(['player_team_id' => $team->team_id, 'player_loan_team_id' => 0])
            ->orderBy(['player_tire' => SORT_ASC])
            ->all();

        for ($j = 0; $j < Lineup::GAME_QUANTITY; $j++) {
            if (in_array($j, [0])) {
                $lineId = 0;
            } elseif (in_array($j, [1, 2, 3, 4, 5, 6])) {
                $lineId = 1;
            } elseif (in_array($j, [7, 8, 9, 10, 11])) {
                $lineId = 2;
            } elseif (in_array($j, [12, 13, 14, 15, 16])) {
                $lineId = 3;
            } else {
                $lineId = 4;
            }

            if (in_array($j, [0, 1])) {
                $positionId = Position::GK;
            } elseif (in_array($j, [2, 7, 12, 17])) {
                $positionId = Position::LD;
            } elseif (in_array($j, [3, 8, 13, 18])) {
                $positionId = Position::RD;
            } elseif (in_array($j, [4, 9, 14, 19])) {
                $positionId = Position::LW;
            } elseif (in_array($j, [5, 10, 15, 20])) {
                $positionId = Position::CF;
            } else {
                $positionId = Position::RW;
            }

            $player = null;
            foreach ($playerArray as $key => $playerItem) {
                if (!$player && $playerItem->player_position_id == $positionId) {
                    $player = $playerItem;
                    unset($playerArray[$key]);
                }
            }

            if (!$player) {
                continue;
            }

            $lineup = new Lineup();
            $lineup->lineup_line_id = $lineId;
            $lineup->lineup_position_id = $positionId;
            $lineup->lineup_team_id = $team->team_id;
            $lineup->lineup_game_id = $game->game_id;
            $lineup->lineup_player_id = $player->player_id;
            $lineup->save(false, [
                'lineup_line_id',
                'lineup_position_id',
                'lineup_team_id',
                'lineup_game_id',
                'lineup_player_id',
            ]);
        }
    }


}