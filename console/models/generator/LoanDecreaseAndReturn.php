<?php

namespace console\models\generator;

use common\models\History;
use common\models\HistoryText;
use common\models\Player;

/**
 * Class LoanDecreaseAndReturn
 * @package console\models\generator
 */
class LoanDecreaseAndReturn
{
    /**
     * @return void
     */
    public function execute(): void
    {
        Player::updateAllCounters(['player_loan_day' => -1], ['!=', 'player_loan_team_id', 0]);

        $playerArray = Player::find()
            ->where(['<=', 'player_loan_day', 0])
            ->andWhere(['!=', 'player_loan_team_id', 0])
            ->each();
        foreach ($playerArray as $player) {
            /**
             * @var Player $player
             */
            History::log([
                'history_history_text_id' => HistoryText::PLAYER_LOAN_BACK,
                'history_player_id' => $player->player_id,
                'history_team_id' => $player->player_team_id,
                'history_team_2_id' => $player->player_loan_team_id,
            ]);
        }

        Player::updateAll(
            ['player_loan_team_id' => 0],
            ['and', ['!=', 'player_loan_team_id', 0], ['<=', 'player_loan_day', 0]]
        );
    }
}