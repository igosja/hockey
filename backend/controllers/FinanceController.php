<?php

namespace backend\controllers;

use common\models\Finance;
use common\models\FinanceText;
use common\models\Loan;
use common\models\Team;
use common\models\Transfer;

/**
 * Class FinanceController
 * @package backend\controllers
 */
class FinanceController extends AbstractController
{
    /**
     * @throws \Exception
     * @return void
     */
    public function actionIndex()
    {
        $teamArray = Team::find()
            ->select(['team_id', 'team_finance'])
            ->where(['!=', 'team_id', 0])
            ->andWhere([
                'or',
                [
                    'team_id' => Transfer::find()
                        ->select(['transfer_team_buyer_id'])
                        ->where(['!=', 'transfer_cancel', 0])
                ],
                [
                    'team_id' => Loan::find()
                        ->select(['loan_team_buyer_id'])
                        ->where(['!=', 'loan_cancel', 0])
                ]
            ])
            ->each();
        foreach ($teamArray as $team) {
            $value = 0;
            /**
             * @var Team $team
             */
            $financeArray = Finance::find()
                ->where(['finance_team_id' => $team->team_id])
                ->orderBy(['finance_id' => SORT_ASC])
                ->all();
            foreach ($financeArray as $finance) {
                $finance->finance_value_before = $value;
                $finance->finance_value_after = $value + $finance->finance_value;

                if (FinanceText::TEAM_RE_REGISTER == $finance->finance_finance_text_id) {
                    $finance->finance_value = Team::START_MONEY - $value;
                    $finance->finance_value_after = Team::START_MONEY;
                }

                $finance->save(true, ['finance_value_before', 'finance_value_after', 'finance_value']);
                $value = $finance->finance_value_after;
            }
            $team->team_finance = $value;
            $team->save(true, ['team_finance']);
        }
    }
}
