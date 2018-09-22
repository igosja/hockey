<?php

namespace console\models\generator;

use common\models\Finance;
use common\models\FinanceText;
use common\models\History;
use common\models\HistoryText;
use common\models\Transfer;
use common\models\TransferVote;

/**
 * Class TransferCheck
 * @package console\models\generator
 */
class TransferCheck
{
    /**
     * @return void
     */
    public function execute(): void
    {
        $transferArray = Transfer::find()
            ->where(['transfer_checked' => 0])
            ->andWhere(['!=', 'transfer_ready', 0])
            ->andWhere('FROM_UNIXTIME(`transfer_ready`+604800, "%Y-%m-%d")<=CURDATE()')
            ->orderBy(['transfer_id' => SORT_ASC])
            ->each();
        foreach ($transferArray as $transfer) {
            /**
             * @var Transfer $transfer
             */
            $check = TransferVote::find()
                ->where(['transfer_vote_transfer_id' => $transfer->transfer_id])
                ->sum('transfer_vote_rating');
            if ($check < 0) {
                $schoolPrice = round($transfer->transfer_price_buyer / 100);

                Finance::log([
                    'finance_finance_text_id' => FinanceText::INCOME_TRANSFER_FIRST_TEAM,
                    'finance_player_id' => $transfer->transfer_player_id,
                    'finance_team_id' => $transfer->player->player_school_id,
                    'finance_value' => -$schoolPrice,
                    'finance_value_after' => $transfer->player->schoolTeam->team_finance - $schoolPrice,
                    'finance_value_before' => $transfer->player->schoolTeam->team_finance,
                ]);

                $transfer->player->schoolTeam->team_finance = $transfer->player->schoolTeam->team_finance - $schoolPrice;
                $transfer->player->schoolTeam->save();

                if ($transfer->transfer_team_seller_id) {
                    Finance::log([
                        'finance_finance_text_id' => FinanceText::INCOME_TRANSFER,
                        'finance_player_id' => $transfer->transfer_player_id,
                        'finance_team_id' => $transfer->transfer_team_seller_id,
                        'finance_value' => -$transfer->transfer_price_buyer,
                        'finance_value_after' => $transfer->seller->team_finance - $transfer->transfer_price_buyer,
                        'finance_value_before' => $transfer->seller->team_finance,
                    ]);

                    $transfer->seller->team_finance = $transfer->seller->team_finance - $transfer->transfer_price_buyer;
                    $transfer->seller->save();
                }

                if ($transfer->transfer_team_buyer_id) {
                    Finance::log([
                        'finance_finance_text_id' => FinanceText::OUTCOME_TRANSFER,
                        'finance_player_id' => $transfer->transfer_player_id,
                        'finance_team_id' => $transfer->transfer_team_buyer_id,
                        'finance_value' => $transfer->transfer_price_buyer,
                        'finance_value_after' => $transfer->buyer->team_finance + $transfer->transfer_price_buyer,
                        'finance_value_before' => $transfer->buyer->team_finance,
                    ]);

                    $transfer->buyer->team_finance = $transfer->buyer->team_finance - $transfer->transfer_price_buyer;
                    $transfer->buyer->save();
                }

                $transfer->player->player_squad_id = 0;
                $transfer->player->player_date_no_action = 0;
                $transfer->player->player_no_deal = 0;
                $transfer->player->player_team_id = $transfer->transfer_team_seller_id;
                $transfer->player->save();

                History::log([
                    'history_history_text_id' => HistoryText::PLAYER_TRANSFER,
                    'history_player_id' => $transfer->transfer_player_id,
                    'history_team_id' => $transfer->transfer_team_buyer_id,
                    'history_team_2_id' => $transfer->transfer_team_seller_id,
                    'history_value' => $transfer->transfer_price_buyer,
                ]);

                $transfer->transfer_cancel = time();
                $transfer->save();
            }
        }

        Transfer::updateAll(
            ['transfer_checked' => time()],
            [
                'and',
                ['!=', 'transfer_ready', 0],
                ['transfer_checked' => 0],
                'FROM_UNIXTIME(`transfer_date`+604800, "%Y-%m-%d")=CURDATE()',
            ]
        );
    }
}