<?php

namespace backend\controllers;

use common\models\Finance;
use common\models\Team;

/**
 * Class CityController
 * @package backend\controllers
 */
class FinanceController extends AbstractController
{
    /**
     * @throws \Exception
     * @return void
     */
    public function actionIndex(): void
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
                $finance->save(true, ['finance_value_before', 'finance_value_after']);
                $value = $finance->finance_value_after;
            }
            $team->team_finance = $value;
            $team->save(true, ['team_finance']);
        }
    }
}
