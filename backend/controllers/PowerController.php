<?php

namespace backend\controllers;

use common\models\History;
use common\models\HistoryText;
use common\models\Player;

/**
 * Class PowerController
 * @package backend\controllers
 */
class PowerController extends AbstractController
{
    /**
     * @throws \Exception
     * @return void
     */
    public function actionIndex(): void
    {
        $playerArray = Player::find()
            ->select(['player_id', 'player_age', 'player_power_nominal'])
            ->where(['!=', 'player_team_id', 0])
            ->each();
        foreach ($playerArray as $player) {
            /**
             * @var Player $player
             */
            $power = $player->player_age * 2;
            $plus = History::find()
                ->where([
                    'history_player_id' => $player->player_id,
                    'history_history_text_id' => [
                        HistoryText::PLAYER_BONUS_POINT,
                        HistoryText::PLAYER_GAME_POINT_PLUS,
                        HistoryText::PLAYER_TRAINING_POINT,
                    ]
                ])
                ->count();
            $minus = History::find()
                ->where([
                    'history_player_id' => $player->player_id,
                    'history_history_text_id' => [
                        HistoryText::PLAYER_GAME_POINT_MINUS,
                    ]
                ])
                ->count();
            $player->player_power_nominal = $power + $plus - $minus;
            $player->save(true, ['player_power_nominal']);
        }
    }
}
