<?php

namespace console\models\generator;

use common\models\Finance;
use common\models\FinanceText;
use common\models\History;
use common\models\HistoryText;
use common\models\Team;
use common\models\Transfer;
use common\models\TransferVote;

/**
 * Class TransferCheck
 * @package console\models\generator
 */
class TransferCheck
{
    /**
     * @throws \Exception
     * @return void
     */
    public function execute()
    {
        $transferArray = Transfer::find()
            ->with(['player'])
            ->where(['transfer_checked' => 0])
            ->andWhere(['!=', 'transfer_ready', 0])
            ->andWhere('FROM_UNIXTIME(`transfer_ready`+604800, "%Y-%m-%d")<=CURDATE()')
            ->orderBy(['transfer_id' => SORT_ASC])
            ->each(5);
        foreach ($transferArray as $transfer) {
            /**
             * @var Transfer $transfer
             */
            $check = TransferVote::find()
                ->where(['transfer_vote_transfer_id' => $transfer->transfer_id])
                ->sum('transfer_vote_rating');
            if ($check < 0) {
                $schoolPrice = round($transfer->transfer_price_buyer / 100);

                $schoolTeam = Team::find()
                    ->where(['team_id' => $transfer->player->player_school_id])
                    ->limit(1)
                    ->one();

                Finance::log([
                    'finance_finance_text_id' => FinanceText::INCOME_TRANSFER_FIRST_TEAM,
                    'finance_player_id' => $transfer->transfer_player_id,
                    'finance_team_id' => $transfer->player->player_school_id,
                    'finance_value' => -$schoolPrice,
                    'finance_value_after' => $schoolTeam->team_finance - $schoolPrice,
                    'finance_value_before' => $schoolTeam->team_finance,
                ]);

                $schoolTeam->team_finance = $schoolTeam->team_finance - $schoolPrice;
                $schoolTeam->save(true, ['team_finance']);

                if ($transfer->transfer_team_seller_id) {
                    $sellerTeam = Team::find()
                        ->where(['team_id' => $transfer->transfer_team_seller_id])
                        ->limit(1)
                        ->one();

                    Finance::log([
                        'finance_finance_text_id' => FinanceText::INCOME_TRANSFER,
                        'finance_player_id' => $transfer->transfer_player_id,
                        'finance_team_id' => $transfer->transfer_team_seller_id,
                        'finance_value' => -$transfer->transfer_price_buyer,
                        'finance_value_after' => $sellerTeam->team_finance - $transfer->transfer_price_buyer,
                        'finance_value_before' => $sellerTeam->team_finance,
                    ]);

                    $sellerTeam->team_finance = $sellerTeam->team_finance - $transfer->transfer_price_buyer;
                    $sellerTeam->save(true, ['team_finance']);
                }

                if ($transfer->transfer_team_buyer_id) {
                    $buyerTeam = Team::find()
                        ->where(['team_id' => $transfer->transfer_team_buyer_id])
                        ->limit(1)
                        ->one();

                    Finance::log([
                        'finance_finance_text_id' => FinanceText::OUTCOME_TRANSFER,
                        'finance_player_id' => $transfer->transfer_player_id,
                        'finance_team_id' => $transfer->transfer_team_buyer_id,
                        'finance_value' => $transfer->transfer_price_buyer,
                        'finance_value_after' => $buyerTeam->team_finance + $transfer->transfer_price_buyer,
                        'finance_value_before' => $buyerTeam->team_finance,
                    ]);

                    $buyerTeam->team_finance = $buyerTeam->team_finance + $transfer->transfer_price_buyer;
                    $buyerTeam->save(true, ['team_finance']);
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
                $transfer->save(true, ['transfer_cancel']);
            }
        }

        Transfer::updateAll(
            ['transfer_checked' => time()],
            [
                'and',
                ['!=', 'transfer_ready', 0],
                ['transfer_checked' => 0],
                'FROM_UNIXTIME(`transfer_ready`+604800, "%Y-%m-%d")<=CURDATE()',
            ]
        );
    }
}