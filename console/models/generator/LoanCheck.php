<?php

namespace console\models\generator;

use common\models\Finance;
use common\models\FinanceText;
use common\models\Loan;
use common\models\LoanVote;

/**
 * Class LoanCheck
 * @package console\models\generator
 */
class LoanCheck
{
    /**
     * @return void
     */
    public function execute(): void
    {
        $loanArray = Loan::find()
            ->with(['seller', 'buyer'])
            ->where(['loan_checked' => 0])
            ->andWhere(['!=', 'loan_ready', 0])
            ->andWhere('FROM_UNIXTIME(`loan_ready`+604800, "%Y-%m-%d")<=CURDATE()')
            ->orderBy(['loan_id' => SORT_ASC])
            ->each();
        foreach ($loanArray as $loan) {
            /**
             * @var Loan $loan
             */
            $check = LoanVote::find()
                ->where(['loan_vote_loan_id' => $loan->loan_id])
                ->sum('loan_vote_rating');
            if ($check < 0) {
                Finance::log([
                    'finance_finance_text_id' => FinanceText::INCOME_LOAN,
                    'finance_player_id' => $loan->loan_player_id,
                    'finance_team_id' => $loan->loan_team_seller_id,
                    'finance_value' => -$loan->loan_price_buyer,
                    'finance_value_after' => $loan->seller->team_finance - $loan->loan_price_buyer,
                    'finance_value_before' => $loan->seller->team_finance,
                ]);

                $loan->seller->team_finance = $loan->seller->team_finance - $loan->loan_price_buyer;
                $loan->seller->save();

                Finance::log([
                    'finance_finance_text_id' => FinanceText::OUTCOME_LOAN,
                    'finance_player_id' => $loan->loan_player_id,
                    'finance_team_id' => $loan->loan_team_buyer_id,
                    'finance_value' => $loan->loan_price_buyer,
                    'finance_value_after' => $loan->buyer->team_finance + $loan->loan_price_buyer,
                    'finance_value_before' => $loan->buyer->team_finance,
                ]);

                $loan->buyer->team_finance = $loan->buyer->team_finance - $loan->loan_price_buyer;
                $loan->buyer->save();

                $loan->loan_cancel = time();
                $loan->save();
            }
        }

        Loan::updateAll(
            ['loan_checked' => time()],
            [
                'and',
                ['!=', 'loan_ready', 0],
                ['loan_checked' => 0],
                'FROM_UNIXTIME(`loan_ready`+604800, "%Y-%m-%d")=CURDATE()',
            ]
        );
    }
}