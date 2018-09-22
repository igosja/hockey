<?php

namespace console\models\generator;

use common\models\Finance;
use common\models\FinanceText;
use common\models\History;
use common\models\HistoryText;
use common\models\Loan;
use common\models\PhysicalChange;
use common\models\Schedule;
use common\models\Season;
use common\models\Transfer;
use common\models\TransferApplication;
use common\models\TransferPosition;
use common\models\TransferSpecial;

/**
 * Class MakeTransfer
 * @package console\models\generator
 */
class MakeTransfer
{
    /**
     * @return void
     */
    public function execute(): void
    {
        $seasonId = Season::getCurrentSeason();

        $scheduleQuery = Schedule::find()
            ->select(['schedule_id'])
            ->where('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->limit(1);

        $transferArray = Transfer::find()
            ->joinWith(['player'])
            ->where(['transfer_ready' => 0])
            ->andWhere('`transfer_date`<=UNIX_TIMESTAMP()-86400')
            ->orderBy(['player_price' => SORT_DESC, 'transfer_id' => SORT_ASC])
            ->each();
        foreach ($transferArray as $transfer) {
            /**
             * @var Transfer $transfer
             */
            $teamArray = [$transfer->transfer_team_seller_id];

            $historyArray = Transfer::find()
                ->where(['transfer_season_id' => $seasonId])
                ->andWhere(['!=', 'transfer_team_buyer_id', 0])
                ->andWhere(['!=', 'transfer_team_seller_id', 0])
                ->andWhere([
                    'or',
                    ['transfer_team_seller_id' => $transfer->transfer_team_seller_id],
                    ['transfer_team_buyer_id' => $transfer->transfer_team_seller_id],
                ])
                ->andWhere(['!=', 'transfer_ready', 0])
                ->all();
            foreach ($historyArray as $item) {
                if (!in_array($item->transfer_team_buyer_id, [0, $transfer->transfer_team_seller_id])) {
                    $teamArray[] = $item->transfer_team_buyer_id;
                }

                if (!in_array($item->transfer_team_seller_id, [0, $transfer->transfer_team_seller_id])) {
                    $teamArray[] = $item->transfer_team_seller_id;
                }
            }

            $historyArray = Loan::find()
                ->where(['loan_season_id' => $seasonId])
                ->andWhere(['!=', 'loan_team_buyer_id', 0])
                ->andWhere(['!=', 'loan_team_seller_id', 0])
                ->andWhere([
                    'or',
                    ['loan_team_seller_id' => $transfer->transfer_team_seller_id],
                    ['loan_team_buyer_id' => $transfer->transfer_team_seller_id],
                ])
                ->andWhere(['!=', 'loan_ready', 0])
                ->all();
            foreach ($historyArray as $item) {
                if (!in_array($item->loan_team_buyer_id, [0, $transfer->transfer_team_seller_id])) {
                    $teamArray[] = $item->loan_team_buyer_id;
                }

                if (!in_array($item->loan_team_seller_id, [0, $transfer->transfer_team_seller_id])) {
                    $teamArray[] = $item->loan_team_seller_id;
                }
            }

            $userArray = [$transfer->transfer_user_seller_id];

            $historyArray = Transfer::find()
                ->where(['transfer_season_id' => $seasonId])
                ->andWhere(['!=', 'transfer_user_buyer_id', 0])
                ->andWhere(['!=', 'transfer_user_seller_id', 0])
                ->andWhere([
                    'or',
                    ['transfer_user_seller_id' => $transfer->transfer_team_seller_id],
                    ['transfer_user_buyer_id' => $transfer->transfer_team_seller_id],
                ])
                ->andWhere(['!=', 'transfer_ready', 0])
                ->all();
            foreach ($historyArray as $item) {
                if (!in_array($item->transfer_user_buyer_id, [0, $transfer->transfer_user_seller_id])) {
                    $userArray[] = $item->transfer_user_buyer_id;
                }

                if (!in_array($item->transfer_user_seller_id, [0, $transfer->transfer_user_seller_id])) {
                    $userArray[] = $item->transfer_user_seller_id;
                }
            }

            $historyArray = Loan::find()
                ->where(['loan_season_id' => $seasonId])
                ->andWhere(['!=', 'loan_user_buyer_id', 0])
                ->andWhere(['!=', 'loan_user_seller_id', 0])
                ->andWhere([
                    'or',
                    ['loan_user_seller_id' => $transfer->transfer_team_seller_id],
                    ['loan_user_buyer_id' => $transfer->transfer_team_seller_id],
                ])
                ->andWhere(['!=', 'loan_ready', 0])
                ->all();
            foreach ($historyArray as $item) {
                if (!in_array($item->loan_user_buyer_id, [0, $transfer->transfer_user_seller_id])) {
                    $userArray[] = $item->loan_user_buyer_id;
                }

                if (!in_array($item->loan_user_seller_id, [0, $transfer->transfer_user_seller_id])) {
                    $userArray[] = $item->loan_user_seller_id;
                }
            }

            $transferApplication = TransferApplication::find()
                ->joinWith(['team'])
                ->where(['transfer_application_transfer_id' => $transfer->transfer_id])
                ->andWhere(['not', ['transfer_application_team_id' => $teamArray]])
                ->andWhere(['not', ['transfer_application_user_id' => $userArray]])
                ->andWhere('transfer_application_price<=team_finance')
                ->orderBy(['transfer_application_price' => SORT_DESC, 'transfer_application_date' => SORT_ASC])
                ->limit(1)
                ->one();
            if ($transferApplication) {
                if ($transfer->transfer_team_seller_id) {
                    Finance::log([
                        'finance_finance_text_id' => FinanceText::INCOME_TRANSFER,
                        'finance_player_id' => $transfer->transfer_player_id,
                        'finance_team_id' => $transfer->transfer_team_seller_id,
                        'finance_value' => $transferApplication->transfer_application_price,
                        'finance_value_after' => $transfer->seller->team_finance + $transferApplication->transfer_application_price,
                        'finance_value_before' => $transfer->seller->team_finance,
                    ]);

                    $transfer->seller->team_finance = $transfer->seller->team_finance + $transferApplication->transfer_application_price;
                    $transfer->seller->save();
                }

                $schoolPrice = round($transferApplication->transfer_application_price / 100);

                Finance::log([
                    'finance_finance_text_id' => FinanceText::INCOME_TRANSFER_FIRST_TEAM,
                    'finance_player_id' => $transfer->transfer_player_id,
                    'finance_team_id' => $transfer->player->player_school_id,
                    'finance_value' => $schoolPrice,
                    'finance_value_after' => $transfer->player->schoolTeam->team_finance + $schoolPrice,
                    'finance_value_before' => $transfer->player->schoolTeam->team_finance,
                ]);

                $transfer->player->schoolTeam->team_finance = $transfer->player->schoolTeam->team_finance + $schoolPrice;
                $transfer->player->schoolTeam->save();

                Finance::log([
                    'finance_finance_text_id' => FinanceText::OUTCOME_TRANSFER,
                    'finance_player_id' => $transfer->transfer_player_id,
                    'finance_team_id' => $transferApplication->transfer_application_team_id,
                    'finance_value' => $transferApplication->transfer_application_price,
                    'finance_value_after' => $transferApplication->team->team_finance - $transferApplication->transfer_application_price,
                    'finance_value_before' => $transferApplication->team->team_finance,
                ]);

                $transferApplication->team->team_finance = $transferApplication->team->team_finance - $transferApplication->transfer_application_price;
                $transferApplication->team->save();

                $transfer->player->player_squad_id = 0;
                $transfer->player->player_date_no_action = time() + 604800;
                $transfer->player->player_no_deal = 0;
                $transfer->player->player_order = 0;
                $transfer->player->player_team_id = $transferApplication->transfer_application_team_id;
                $transfer->player->save();

                PhysicalChange::deleteAll([
                    'and',
                    ['physical_change_player_id' => $transfer->transfer_player_id],
                    ['>', 'physical_change_schedule_id', $scheduleQuery],
                ]);

                $transfer->transfer_age = $transfer->player->player_age;
                $transfer->transfer_player_price = $transfer->player->player_price;
                $transfer->transfer_power = $transfer->player->player_power_nominal;
                $transfer->transfer_price_buyer = $transferApplication->transfer_application_price;
                $transfer->transfer_ready = time();
                $transfer->transfer_season_id = $seasonId;
                $transfer->transfer_team_buyer_id = $transferApplication->transfer_application_team_id;
                $transfer->transfer_user_buyer_id = $transferApplication->transfer_application_user_id;
                $transfer->save();

                foreach ($transfer->player->playerPosition as $position) {
                    $transferPosition = new TransferPosition();
                    $transferPosition->transfer_position_position_id = $position->player_position_position_id;
                    $transferPosition->transfer_position_transfer_id = $transfer->transfer_id;
                    $transferPosition->save();
                }

                foreach ($transfer->player->playerSpecial as $special) {
                    $transferSpecial = new TransferSpecial();
                    $transferSpecial->transfer_special_level = $special->player_special_level;
                    $transferSpecial->transfer_special_special_id = $special->player_special_special_id;
                    $transferSpecial->transfer_special_transfer_id = $transfer->transfer_id;
                    $transferSpecial->save();
                }

                History::log([
                    'history_history_text_id' => HistoryText::PLAYER_TRANSFER,
                    'history_player_id' => $transfer->transfer_player_id,
                    'history_team_id' => $transfer->transfer_team_seller_id,
                    'history_team_2_id' => $transferApplication->transfer_application_team_id,
                    'history_value' => $transferApplication->transfer_application_price,
                ]);

                Transfer::deleteAll(['transfer_player_id' => $transfer->transfer_player_id]);
                Loan::deleteAll(['loan_player_id' => $transfer->transfer_player_id]);

                if ($transferApplication->transfer_application_only_one) {
                    $subQuery = Transfer::find()
                        ->select(['transfer_id'])
                        ->where(['transfer_ready' => 0]);

                    TransferApplication::deleteAll([
                        'transfer_application_team_id' => $transferApplication->transfer_application_team_id,
                        'transfer_application_transfer_id' => $subQuery,
                    ]);
                }
            } elseif ($transfer->transfer_to_league) {
                $price = round($transfer->player->player_price / 2);

                Finance::log([
                    'finance_finance_text_id' => FinanceText::INCOME_TRANSFER,
                    'finance_player_id' => $transfer->transfer_player_id,
                    'finance_team_id' => $transfer->transfer_team_seller_id,
                    'finance_value' => $transferApplication->transfer_application_price,
                    'finance_value_after' => $transfer->seller->team_finance + $price,
                    'finance_value_before' => $transfer->seller->team_finance,
                ]);

                $transfer->seller->team_finance = $transfer->seller->team_finance + $price;
                $transfer->seller->save();

                $schoolPrice = round($price / 100);

                Finance::log([
                    'finance_finance_text_id' => FinanceText::INCOME_TRANSFER_FIRST_TEAM,
                    'finance_player_id' => $transfer->transfer_player_id,
                    'finance_team_id' => $transfer->player->player_school_id,
                    'finance_value' => $schoolPrice,
                    'finance_value_after' => $transfer->player->schoolTeam->team_finance + $schoolPrice,
                    'finance_value_before' => $transfer->player->schoolTeam->team_finance,
                ]);

                $transfer->player->schoolTeam->team_finance = $transfer->player->schoolTeam->team_finance + $schoolPrice;
                $transfer->player->schoolTeam->save();

                $transfer->player->player_squad_id = 0;
                $transfer->player->player_date_no_action = time() + 604800;
                $transfer->player->player_no_deal = 0;
                $transfer->player->player_order = 0;
                $transfer->player->player_team_id = 0;
                $transfer->player->save();

                $transfer->transfer_age = $transfer->player->player_age;
                $transfer->transfer_player_price = $transfer->player->player_price;
                $transfer->transfer_power = $transfer->player->player_power_nominal;
                $transfer->transfer_price_buyer = $price;
                $transfer->transfer_ready = time();
                $transfer->transfer_season_id = $seasonId;
                $transfer->save();

                foreach ($transfer->player->playerPosition as $position) {
                    $transferPosition = new TransferPosition();
                    $transferPosition->transfer_position_position_id = $position->player_position_position_id;
                    $transferPosition->transfer_position_transfer_id = $transfer->transfer_id;
                    $transferPosition->save();
                }

                foreach ($transfer->player->playerSpecial as $special) {
                    $transferSpecial = new TransferSpecial();
                    $transferSpecial->transfer_special_level = $special->player_special_level;
                    $transferSpecial->transfer_special_special_id = $special->player_special_special_id;
                    $transferSpecial->transfer_special_transfer_id = $transfer->transfer_id;
                    $transferSpecial->save();
                }

                History::log([
                    'history_history_text_id' => HistoryText::PLAYER_FREE,
                    'history_player_id' => $transfer->transfer_player_id,
                    'history_team_id' => $transfer->transfer_team_seller_id,
                    'history_team_2_id' => $transferApplication->transfer_application_team_id,
                    'history_value' => $transferApplication->transfer_application_price,
                ]);

                Transfer::deleteAll(['transfer_player_id' => $transfer->transfer_player_id]);
                Loan::deleteAll(['loan_player_id' => $transfer->transfer_player_id]);
            }
        }
    }
}