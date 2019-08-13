<?php

namespace console\models\generator;

use common\models\Finance;
use common\models\FinanceText;
use common\models\User;
use Exception;
use yii\db\Expression;

/**
 * Class ReferrerBonus
 * @package console\models\generator
 */
class ReferrerBonus
{
    /**
     * @throws Exception
     */
    public function execute()
    {
        $userArray = User::find()
            ->joinWith(['team'])
            ->with(['referrer'])
            ->where(['!=', 'user_referrer_id', 0])
            ->andWhere(['user_referrer_done' => 0])
            ->andWhere(['>', 'user_date_login', new Expression('user_date_register+2592000')])
            ->andWhere(['not', ['team_user_id' => null]])
            ->andWhere(['!=', 'user_date_confirm', 0])
            ->groupBy(['user_id'])
            ->orderBy(['user_id' => SORT_ASC])
            ->each(5);
        foreach ($userArray as $user) {
            /**
             * @var User $user
             */
            $sum = 1000000;

            Finance::log([
                'finance_finance_text_id' => FinanceText::INCOME_REFERRAL,
                'finance_user_id' => $user->user_referrer_id,
                'finance_value' => $sum,
                'finance_value_after' => $user->referrer->user_finance + $sum,
                'finance_value_before' => $user->referrer->user_finance,
            ]);

            $user->referrer->user_finance = $user->referrer->user_finance + $sum;
            $user->referrer->save(true, ['user_finance']);

            $user->user_referrer_done = 1;
            $user->save(true, ['user_referrer_done']);
        }
    }
}
