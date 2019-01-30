<?php

namespace console\controllers;

use common\models\Finance;
use common\models\FinanceText;
use common\models\Money;
use common\models\MoneyText;
use common\models\Payment;
use common\models\Team;
use Exception;

/**
 * Class FixController
 * @package console\controllers
 */
class FixController extends AbstractController
{
    /**
     * @throws Exception
     */
    public function actionFinance()
    {
        $teamArray = Team::find()
            ->select(['team_id', 'team_finance'])
            ->where(['!=', 'team_id', 0])
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

    /**
     * @throws Exception
     */
    public function actionMoney()
    {
        Money::deleteAll(['money_money_text_id' => MoneyText::INCOME_REFERRAL]);

        $paymentArray = Payment::find()
            ->where(['payment_status' => Payment::PAID])
            ->orderBy(['payment_id' => SORT_ASC])
            ->all();
        foreach ($paymentArray as $payment) {
            if ($payment->user->referrer) {
                $sum = round($payment->payment_sum / 10, 2);

                Money::log([
                    'money_money_text_id' => MoneyText::INCOME_REFERRAL,
                    'money_user_id' => $payment->user->user_referrer_id,
                    'money_value' => $sum,
                    'money_value_after' => $payment->user->referrer->user_money + $sum,
                    'money_value_before' => $payment->user->referrer->user_money,
                ]);

                $payment->user->referrer->user_money = $payment->user->referrer->user_money + $sum;
                $payment->user->referrer->save(true, ['user_money']);
            }
        }
    }
}
