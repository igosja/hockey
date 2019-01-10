<?php

namespace console\models\generator;

use common\models\Finance;
use common\models\FinanceText;
use common\models\Player;
use common\models\Team;

/**
 * Class TakeSalary
 * @package console\models\generator
 */
class TakeSalary
{
    /**
     * @throws \Exception
     * @return void
     */
    public function execute()
    {
        $teamArray = Team::find()
            ->where(['!=', 'team_id', 0])
            ->orderBy(['team_id' => SORT_ASC])
            ->each();
        foreach ($teamArray as $team) {
            /**
             * @var Team $team
             */
            $salary = Player::find()
                ->where(['player_team_id' => $team->team_id, 'player_loan_team_id' => 0])
                ->orWhere(['player_loan_team_id' => $team->team_id])
                ->sum('player_salary');

            Finance::log([
                'finance_finance_text_id' => FinanceText::OUTCOME_SALARY,
                'finance_team_id' => $team->team_id,
                'finance_value' => -$salary,
                'finance_value_after' => $team->team_finance - $salary,
                'finance_value_before' => $team->team_finance,
            ]);

            $team->team_finance = $team->team_finance - $salary;
            $team->save();
        }
    }
}