<?php

namespace console\models\generator;

use common\models\DealReason;
use common\models\Finance;
use common\models\FinanceText;
use common\models\History;
use common\models\HistoryText;
use common\models\Loan;
use common\models\PhysicalChange;
use common\models\Schedule;
use common\models\Season;
use common\models\Team;
use common\models\Transfer;
use common\models\TransferApplication;
use common\models\TransferPosition;
use common\models\TransferSpecial;
use Throwable;
use yii\db\StaleObjectException;

/**
 * Class MakeTransfer
 * @package console\models\generator
 */
class MakeTransfer
{
    /**
     * @return void
     * @throws StaleObjectException
     * @throws Throwable
     */
    public function execute()
    {
        $seasonId = Season::getCurrentSeason();

        $scheduleQuery = Schedule::find()
            ->select(['schedule_id'])
            ->where('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->limit(1);

        $transferArray = Transfer::find()
            ->joinWith(['player'])
            ->with(['player'])
            ->where(['transfer_ready' => 0])
            ->andWhere('`transfer_date`<=UNIX_TIMESTAMP()-86400')
            ->orderBy(['player_price' => SORT_DESC, 'transfer_id' => SORT_ASC])
            ->each(5);
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
                    ['transfer_user_seller_id' => $transfer->transfer_user_seller_id],
                    ['transfer_user_buyer_id' => $transfer->transfer_user_seller_id],
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
                    ['loan_user_seller_id' => $transfer->transfer_user_seller_id],
                    ['loan_user_buyer_id' => $transfer->transfer_user_seller_id],
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

            $sold = false;

            $transferApplicationArray = TransferApplication::find()
                ->where(['transfer_application_transfer_id' => $transfer->transfer_id])
                ->orderBy(['transfer_application_price' => SORT_DESC, 'transfer_application_date' => SORT_ASC])
                ->all();
            foreach ($transferApplicationArray as $transferApplication) {
                if (in_array($transferApplication->transfer_application_team_id, $teamArray)) {
                    $transferApplication->transfer_application_deal_reason_id = DealReason::TEAM_LIMIT;
                    $transferApplication->save(true, ['transfer_application_deal_reason_id']);
                    continue;
                }
                if (in_array($transferApplication->transfer_application_user_id, $userArray)) {
                    $transferApplication->transfer_application_deal_reason_id = DealReason::MANAGER_LIMIT;
                    $transferApplication->save(true, ['transfer_application_deal_reason_id']);
                    continue;
                }
                if ($transferApplication->user->user_id == $transfer->managerSeller->user_referrer_id || $transferApplication->user->user_referrer_id == $transfer->transfer_user_seller_id) {
                    $transferApplication->transfer_application_deal_reason_id = DealReason::MANAGER_LIMIT;
                    $transferApplication->save(true, ['transfer_application_deal_reason_id']);
                    continue;
                }
            }

            $transferApplicationArray = TransferApplication::find()
                ->where([
                    'transfer_application_transfer_id' => $transfer->transfer_id,
                    'transfer_application_deal_reason_id' => 0
                ])
                ->orderBy(['transfer_application_price' => SORT_DESC, 'transfer_application_date' => SORT_ASC])
                ->all();
            foreach ($transferApplicationArray as $transferApplication) {
                if ($sold) {
                    $transferApplication->transfer_application_deal_reason_id = DealReason::NOT_BEST;
                    $transferApplication->save(true, ['transfer_application_deal_reason_id']);
                    continue;
                }
                $buyerTeam = Team::find()
                    ->where(['team_id' => $transferApplication->transfer_application_team_id])
                    ->limit(1)
                    ->one();
                /**
                 * @var TransferApplication $transferApplication
                 */
                if (1 == count($transferApplicationArray) && $buyerTeam->team_finance > $transfer->transfer_price_seller) {
                    $transferApplication->transfer_application_price = $transfer->transfer_price_seller;
                }
                if (count($transferApplicationArray) > 1 && $transferApplication->transfer_application_id == $transferApplicationArray[0]->transfer_application_id) {
                    $transferApplication->transfer_application_price = $transferApplicationArray[1]->transfer_application_price + 1;
                }
                if ($transferApplication->transfer_application_price > $transferApplication->team->team_finance) {
                    $transferApplication->transfer_application_deal_reason_id = DealReason::NO_MONEY;
                    $transferApplication->save(true, ['transfer_application_deal_reason_id']);
                    continue;
                }
                if ($transfer->transfer_team_seller_id) {
                    $sellerTeam = Team::find()
                        ->where(['team_id' => $transfer->transfer_team_seller_id])
                        ->limit(1)
                        ->one();
                    Finance::log([
                        'finance_finance_text_id' => FinanceText::INCOME_TRANSFER,
                        'finance_player_id' => $transfer->transfer_player_id,
                        'finance_team_id' => $transfer->transfer_team_seller_id,
                        'finance_value' => $transferApplication->transfer_application_price,
                        'finance_value_after' => $sellerTeam->team_finance + $transferApplication->transfer_application_price,
                        'finance_value_before' => $sellerTeam->team_finance,
                    ]);

                    $sellerTeam->team_finance = $sellerTeam->team_finance + $transferApplication->transfer_application_price;
                    $sellerTeam->save(true, ['team_finance']);
                }

                $schoolPrice = round($transferApplication->transfer_application_price / 100);

                $schoolTeam = Team::find()
                    ->where(['team_id' => $transfer->player->player_school_id])
                    ->limit(1)
                    ->one();

                Finance::log([
                    'finance_finance_text_id' => FinanceText::INCOME_TRANSFER_FIRST_TEAM,
                    'finance_player_id' => $transfer->transfer_player_id,
                    'finance_team_id' => $transfer->player->player_school_id,
                    'finance_value' => $schoolPrice,
                    'finance_value_after' => $schoolTeam->team_finance + $schoolPrice,
                    'finance_value_before' => $schoolTeam->team_finance,
                ]);

                $schoolTeam->team_finance = $schoolTeam->team_finance + $schoolPrice;
                $schoolTeam->save(true, ['team_finance']);

                Finance::log([
                    'finance_finance_text_id' => FinanceText::OUTCOME_TRANSFER,
                    'finance_player_id' => $transfer->transfer_player_id,
                    'finance_team_id' => $transferApplication->transfer_application_team_id,
                    'finance_value' => -$transferApplication->transfer_application_price,
                    'finance_value_after' => $buyerTeam->team_finance - $transferApplication->transfer_application_price,
                    'finance_value_before' => $buyerTeam->team_finance,
                ]);

                $buyerTeam->team_finance = $buyerTeam->team_finance - $transferApplication->transfer_application_price;
                $buyerTeam->save(true, ['team_finance']);

                $transfer->player->player_squad_id = 0;
                $transfer->player->player_date_no_action = time() + 604800;
                $transfer->player->player_no_deal = 1;
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

                $transferDeleteArray = Transfer::find()
                    ->where(['transfer_player_id' => $transfer->transfer_player_id, 'transfer_ready' => 0])
                    ->all();
                foreach ($transferDeleteArray as $transferDelete) {
                    $transferDelete->delete();
                }

                $loanDeleteArray = Loan::find()
                    ->where(['loan_player_id' => $transfer->transfer_player_id, 'loan_ready' => 0])
                    ->all();
                foreach ($loanDeleteArray as $loadDelete) {
                    $loadDelete->delete();
                }

                if ($transferApplication->transfer_application_only_one) {
                    $subQuery = Transfer::find()
                        ->select(['transfer_id'])
                        ->where(['transfer_ready' => 0]);

                    TransferApplication::deleteAll([
                        'transfer_application_team_id' => $transferApplication->transfer_application_team_id,
                        'transfer_application_transfer_id' => $subQuery,
                    ]);
                }

                $transferApplication->transfer_application_deal_reason_id = 0;
                $transferApplication->save(true, ['transfer_application_deal_reason_id', 'transfer_application_price']);

                $sold = true;
            }
            if ($transfer->transfer_to_league && !$sold) {
                $price = round($transfer->player->player_price / 2);

                $sellerTeam = Team::find()
                    ->where(['team_id' => $transfer->transfer_team_seller_id])
                    ->limit(1)
                    ->one();

                Finance::log([
                    'finance_finance_text_id' => FinanceText::INCOME_TRANSFER,
                    'finance_player_id' => $transfer->transfer_player_id,
                    'finance_team_id' => $transfer->transfer_team_seller_id,
                    'finance_value' => $price,
                    'finance_value_after' => $sellerTeam->team_finance + $price,
                    'finance_value_before' => $sellerTeam->team_finance,
                ]);

                $sellerTeam->team_finance = $sellerTeam->team_finance + $price;
                $sellerTeam->save(true, ['team_finance']);

                $schoolPrice = round($price / 100);

                $schoolTeam = Team::find()
                    ->where(['team_id' => $transfer->player->player_school_id])
                    ->limit(1)
                    ->one();

                Finance::log([
                    'finance_finance_text_id' => FinanceText::INCOME_TRANSFER_FIRST_TEAM,
                    'finance_player_id' => $transfer->transfer_player_id,
                    'finance_team_id' => $transfer->player->player_school_id,
                    'finance_value' => $schoolPrice,
                    'finance_value_after' => $schoolTeam->team_finance + $schoolPrice,
                    'finance_value_before' => $schoolTeam->team_finance,
                ]);

                $schoolTeam->team_finance = $schoolTeam->team_finance + $schoolPrice;
                $schoolTeam->save(true, ['team_finance']);

                $transfer->player->player_squad_id = 0;
                $transfer->player->player_date_no_action = time() + 604800;
                $transfer->player->player_no_deal = 1;
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
                    'history_team_2_id' => 0,
                    'history_value' => $price,
                ]);

                $transferDeleteArray = Transfer::find()
                    ->where(['transfer_player_id' => $transfer->transfer_player_id, 'transfer_ready' => 0])
                    ->all();
                foreach ($transferDeleteArray as $transferDelete) {
                    $transferDelete->delete();
                }

                $loanDeleteArray = Loan::find()
                    ->where(['loan_player_id' => $transfer->transfer_player_id, 'loan_ready' => 0])
                    ->all();
                foreach ($loanDeleteArray as $loadDelete) {
                    $loadDelete->delete();
                }
            }
        }
    }
}
