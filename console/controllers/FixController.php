<?php

namespace console\controllers;

use common\models\Finance;
use common\models\FinanceText;
use common\models\Review;
use common\models\ReviewGame;
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

    public function actionReview()
    {
        ReviewGame::deleteAll(['not', ['review_game_review_id' => Review::find()->select(['review_id'])]]);
    }
}
