<?php

namespace console\models\generator;

use common\models\DealReason;
use common\models\Finance;
use common\models\FinanceText;
use common\models\History;
use common\models\HistoryText;
use common\models\Loan;
use common\models\LoanApplication;
use common\models\LoanPosition;
use common\models\LoanSpecial;
use common\models\PhysicalChange;
use common\models\Schedule;
use common\models\Season;
use common\models\Team;
use common\models\Transfer;
use yii\db\Expression;

/**
 * Class MakeLoan
 * @package console\models\generator
 */
class MakeLoan
{
    /**
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @return void
     */
    public function execute()
    {
        $seasonId = Season::getCurrentSeason();

        $scheduleQuery = Schedule::find()
            ->select(['schedule_id'])
            ->where('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->limit(1);

        $loanArray = Loan::find()
            ->joinWith(['player'])
            ->with(['player'])
            ->where(['loan_ready' => 0])
            ->andWhere('`loan_date`<=UNIX_TIMESTAMP()-86400')
            ->orderBy(['player_price' => SORT_DESC, 'loan_id' => SORT_ASC])
            ->each();
        foreach ($loanArray as $loan) {
            /**
             * @var Loan $loan
             */
            $teamArray = [$loan->loan_team_seller_id];

            $historyArray = Transfer::find()
                ->where(['transfer_season_id' => $seasonId])
                ->andWhere(['!=', 'transfer_team_buyer_id', 0])
                ->andWhere(['!=', 'transfer_team_seller_id', 0])
                ->andWhere([
                    'or',
                    ['transfer_team_seller_id' => $loan->loan_team_seller_id],
                    ['transfer_team_buyer_id' => $loan->loan_team_seller_id],
                ])
                ->andWhere(['!=', 'transfer_ready', 0])
                ->all();
            foreach ($historyArray as $item) {
                if (!in_array($item->transfer_team_buyer_id, [0, $loan->loan_team_seller_id])) {
                    $teamArray[] = $item->transfer_team_buyer_id;
                }

                if (!in_array($item->transfer_team_seller_id, [0, $loan->loan_team_seller_id])) {
                    $teamArray[] = $item->transfer_team_seller_id;
                }
            }

            $historyArray = Loan::find()
                ->where(['loan_season_id' => $seasonId])
                ->andWhere(['!=', 'loan_team_buyer_id', 0])
                ->andWhere(['!=', 'loan_team_seller_id', 0])
                ->andWhere([
                    'or',
                    ['loan_team_seller_id' => $loan->loan_team_seller_id],
                    ['loan_team_buyer_id' => $loan->loan_team_seller_id],
                ])
                ->andWhere(['!=', 'loan_ready', 0])
                ->all();
            foreach ($historyArray as $item) {
                if (!in_array($item->loan_team_buyer_id, [0, $loan->loan_team_seller_id])) {
                    $teamArray[] = $item->loan_team_buyer_id;
                }

                if (!in_array($item->loan_team_seller_id, [0, $loan->loan_team_seller_id])) {
                    $teamArray[] = $item->loan_team_seller_id;
                }
            }

            $userArray = [$loan->loan_user_seller_id];

            $historyArray = Transfer::find()
                ->where(['transfer_season_id' => $seasonId])
                ->andWhere(['!=', 'transfer_user_buyer_id', 0])
                ->andWhere(['!=', 'transfer_user_seller_id', 0])
                ->andWhere([
                    'or',
                    ['transfer_user_seller_id' => $loan->loan_user_seller_id],
                    ['transfer_user_buyer_id' => $loan->loan_user_seller_id],
                ])
                ->andWhere(['!=', 'transfer_ready', 0])
                ->all();
            foreach ($historyArray as $item) {
                if (!in_array($item->transfer_user_buyer_id, [0, $loan->loan_user_seller_id])) {
                    $userArray[] = $item->transfer_user_buyer_id;
                }

                if (!in_array($item->transfer_user_seller_id, [0, $loan->loan_user_seller_id])) {
                    $userArray[] = $item->transfer_user_seller_id;
                }
            }

            $historyArray = Loan::find()
                ->where(['loan_season_id' => $seasonId])
                ->andWhere(['!=', 'loan_user_buyer_id', 0])
                ->andWhere(['!=', 'loan_user_seller_id', 0])
                ->andWhere([
                    'or',
                    ['loan_user_seller_id' => $loan->loan_user_seller_id],
                    ['loan_user_buyer_id' => $loan->loan_user_seller_id],
                ])
                ->andWhere(['!=', 'loan_ready', 0])
                ->all();
            foreach ($historyArray as $item) {
                if (!in_array($item->loan_user_buyer_id, [0, $loan->loan_user_seller_id])) {
                    $userArray[] = $item->loan_user_buyer_id;
                }

                if (!in_array($item->loan_user_seller_id, [0, $loan->loan_user_seller_id])) {
                    $userArray[] = $item->loan_user_seller_id;
                }
            }

            $sold = false;

            $loanApplicationArray = LoanApplication::find()
                ->where(['loan_application_loan_id' => $loan->loan_id])
                ->orderBy(new Expression('loan_application_price*loan_application_day DESC, loan_application_date ASC'))
                ->all();
            foreach ($loanApplicationArray as $loanApplication) {
                if (in_array($loanApplication->loan_application_team_id, $teamArray)) {
                    $loanApplication->loan_application_deal_reason_id = DealReason::TEAM_LIMIT;
                    $loanApplication->save(true, ['loan_application_deal_reason_id']);
                    continue;
                }
                if (in_array($loanApplication->loan_application_user_id, $userArray)) {
                    $loanApplication->loan_application_deal_reason_id = DealReason::MANAGER_LIMIT;
                    $loanApplication->save(true, ['loan_application_deal_reason_id']);
                    continue;
                }
            }

            $loanApplicationArray = LoanApplication::find()
                ->where(['loan_application_loan_id' => $loan->loan_id, 'loan_application_deal_reason_id' => 0])
                ->orderBy(new Expression('loan_application_price*loan_application_day DESC, loan_application_date ASC'))
                ->all();
            foreach ($loanApplicationArray as $loanApplication) {
                if ($sold) {
                    $loanApplication->loan_application_deal_reason_id = DealReason::NOT_BEST;
                    $loanApplication->save(true, ['loan_application_deal_reason_id']);
                    continue;
                }

                $price = $loanApplication->loan_application_price * $loanApplication->loan_application_day;

                $buyerTeam = Team::find()
                    ->where(['team_id' => $loanApplication->loan_application_team_id])
                    ->limit(1)
                    ->one();
                /**
                 * @var LoanApplication $loanApplication
                 */
                if (1 == count($loanApplicationArray) && $buyerTeam->team_finance > $loan->loan_price_seller * $loanApplication->loan_application_day) {
                    $loanApplication->loan_application_price = $loan->loan_price_seller;
                    $price = $loanApplication->loan_application_price * $loanApplication->loan_application_day;
                }
                if (count($loanApplicationArray) > 1 && $loanApplication->loan_application_id == $loanApplicationArray[0]->loan_application_id) {
                    $newPrice = ceil($loanApplicationArray[1]->loan_application_price * $loanApplicationArray[1]->loan_application_day / $loanApplication->loan_application_day) + 1;
                    if ($loanApplication->loan_application_price > $newPrice) {
                        $loanApplication->loan_application_price = $newPrice;
                        $price = $loanApplication->loan_application_price * $loanApplication->loan_application_day;
                    }
                }
                if ($price > $buyerTeam->team_finance) {
                    $loanApplication->loan_application_deal_reason_id = DealReason::NO_MONEY;
                    $loanApplication->save(true, ['loan_application_deal_reason_id']);
                    continue;
                }

                $sellerTeam = Team::find()
                    ->where(['team_id' => $loan->loan_team_seller_id])
                    ->limit(1)
                    ->one();
                Finance::log([
                    'finance_finance_text_id' => FinanceText::INCOME_LOAN,
                    'finance_player_id' => $loan->loan_player_id,
                    'finance_team_id' => $loan->loan_team_seller_id,
                    'finance_value' => $price,
                    'finance_value_after' => $sellerTeam->team_finance + $price,
                    'finance_value_before' => $sellerTeam->team_finance,
                ]);

                $sellerTeam->team_finance = $sellerTeam->team_finance + $price;
                $sellerTeam->save(true, ['team_finance']);

                Finance::log([
                    'finance_finance_text_id' => FinanceText::OUTCOME_LOAN,
                    'finance_player_id' => $loan->loan_player_id,
                    'finance_team_id' => $loanApplication->loan_application_team_id,
                    'finance_value' => -$price,
                    'finance_value_after' => $buyerTeam->team_finance - $price,
                    'finance_value_before' => $buyerTeam->team_finance,
                ]);

                $buyerTeam->team_finance = $buyerTeam->team_finance - $price;
                $buyerTeam->save(true, ['team_finance']);

                $loan->player->player_squad_id = 0;
                $loan->player->player_loan_day = $loanApplication->loan_application_day;
                $loan->player->player_order = 0;
                $loan->player->player_loan_team_id = $loanApplication->loan_application_team_id;
                $loan->player->save();

                PhysicalChange::deleteAll([
                    'and',
                    ['physical_change_player_id' => $loan->loan_player_id],
                    ['>', 'physical_change_schedule_id', $scheduleQuery],
                ]);

                $loan->loan_age = $loan->player->player_age;
                $loan->loan_day = $loanApplication->loan_application_day;
                $loan->loan_player_price = $loan->player->player_price;
                $loan->loan_power = $loan->player->player_power_nominal;
                $loan->loan_price_buyer = $price;
                $loan->loan_ready = time();
                $loan->loan_season_id = $seasonId;
                $loan->loan_team_buyer_id = $loanApplication->loan_application_team_id;
                $loan->loan_user_buyer_id = $loanApplication->loan_application_user_id;
                $loan->save();

                foreach ($loan->player->playerPosition as $position) {
                    $loanPosition = new LoanPosition();
                    $loanPosition->loan_position_position_id = $position->player_position_position_id;
                    $loanPosition->loan_position_loan_id = $loan->loan_id;
                    $loanPosition->save();
                }

                foreach ($loan->player->playerSpecial as $special) {
                    $loanSpecial = new LoanSpecial();
                    $loanSpecial->loan_special_level = $special->player_special_level;
                    $loanSpecial->loan_special_special_id = $special->player_special_special_id;
                    $loanSpecial->loan_special_loan_id = $loan->loan_id;
                    $loanSpecial->save();
                }

                History::log([
                    'history_history_text_id' => HistoryText::PLAYER_LOAN,
                    'history_player_id' => $loan->loan_player_id,
                    'history_team_id' => $loan->loan_team_seller_id,
                    'history_team_2_id' => $loanApplication->loan_application_team_id,
                    'history_value' => $price,
                ]);

                $transferDeleteArray = Transfer::find()
                    ->where(['transfer_player_id' => $loan->loan_player_id, 'transfer_ready' => 0])
                    ->all();
                foreach ($transferDeleteArray as $transferDelete) {
                    $transferDelete->delete();
                }

                $loanDeleteArray = Loan::find()
                    ->where(['loan_player_id' => $loan->loan_player_id, 'loan_ready' => 0])
                    ->all();
                foreach ($loanDeleteArray as $loadDelete) {
                    $loadDelete->delete();
                }

                if ($loanApplication->loan_application_only_one) {
                    $subQuery = Loan::find()
                        ->select(['loan_id'])
                        ->where(['loan_ready' => 0]);

                    LoanApplication::deleteAll([
                        'loan_application_team_id' => $loanApplication->loan_application_team_id,
                        'loan_application_loan_id' => $subQuery,
                    ]);
                }

                $loanApplication->loan_application_deal_reason_id = 0;
                $loanApplication->save(true, ['loan_application_deal_reason_id', 'loan_application_price']);

                $sold = true;
            }
        }
    }
}