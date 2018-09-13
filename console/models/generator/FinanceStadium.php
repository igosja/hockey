<?php

namespace console\models\generator;

use common\models\Finance;
use common\models\FinanceText;
use common\models\Game;
use common\models\TournamentType;

/**
 * Class FinanceStadium
 * @package console\models\generator
 *
 * @property Game $game
 * @property int $income
 */
class FinanceStadium
{
    /**
     * @var Game $game
     */
    private $game;

    /**
     * @var int $income
     */
    private $income;

    /**
     * @return void
     */
    public function execute()
    {
        $gameArray = Game::find()
            ->joinWith(['schedule'])
            ->where(['game_played' => 0])
            ->andWhere('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->orderBy(['game_id' => SORT_ASC])
            ->each();
        foreach ($gameArray as $game) {
            $this->game = $game;
            $this->income = $this->game->game_visitor * $this->game->game_ticket;

            if (TournamentType::FRIENDLY == $this->game->schedule->tournamentType->tournament_type_id) {
                $this->friendly();
            } elseif (TournamentType::NATIONAL == $this->game->schedule->tournamentType->tournament_type_id) {
                $this->national();
            } else {
                $this->default();
            }
        }
    }

    /**
     * @return void
     */
    private function friendly()
    {
        $income = floor($this->income / 2);
        $outcome = floor($this->game->stadium->stadium_maintenance / 2);

        Finance::log([
            'finance_finance_text_id' => FinanceText::INCOME_TICKET,
            'finance_team_id' => $this->game->teamHome->team_id,
            'finance_value' => $income,
            'finance_value_after' => $this->game->teamHome->team_finance + $income,
            'finance_value_before' => $this->game->teamHome->team_finance,
        ]);

        Finance::log([
            'finance_finance_text_id' => FinanceText::OUTCOME_GAME,
            'finance_team_id' => $this->game->teamHome->team_id,
            'finance_value' => -$outcome,
            'finance_value_after' => $this->game->teamHome->team_finance + $income - $outcome,
            'finance_value_before' => $this->game->teamHome->team_finance + $income,
        ]);

        $this->game->teamHome->team_finance = $this->game->teamHome->team_finance + $income - $outcome;
        $this->game->teamHome->save();

        Finance::log([
            'finance_finance_text_id' => FinanceText::INCOME_TICKET,
            'finance_team_id' => $this->game->teamGuest->team_id,
            'finance_value' => $income,
            'finance_value_after' => $this->game->teamGuest->team_finance + $income,
            'finance_value_before' => $this->game->teamGuest->team_finance,
        ]);

        Finance::log([
            'finance_finance_text_id' => FinanceText::OUTCOME_GAME,
            'finance_team_id' => $this->game->teamGuest->team_id,
            'finance_value' => -$outcome,
            'finance_value_after' => $this->game->teamGuest->team_finance + $income - $outcome,
            'finance_value_before' => $this->game->teamGuest->team_finance + $income,
        ]);

        $this->game->teamGuest->team_finance = $this->game->teamGuest->team_finance + $income - $outcome;
        $this->game->teamGuest->save();
    }

    /**
     * @return void
     */
    private function national()
    {
        $income = floor($this->income / 3);

        Finance::log([
            'finance_finance_text_id' => FinanceText::INCOME_TICKET,
            'finance_national_id' => $this->game->nationalHome->national_id,
            'finance_value' => $income,
            'finance_value_after' => $this->game->nationalHome->national_finance + $income,
            'finance_value_before' => $this->game->nationalHome->national_finance,
        ]);

        $this->game->nationalHome->national_finance = $this->game->nationalHome->national_finance + $income;
        $this->game->nationalHome->save();

        Finance::log([
            'finance_finance_text_id' => FinanceText::INCOME_TICKET,
            'finance_national_id' => $this->game->nationalGuest->national_id,
            'finance_value' => $income,
            'finance_value_after' => $this->game->nationalGuest->national_finance + $income,
            'finance_value_before' => $this->game->nationalGuest->national_finance,
        ]);

        $this->game->nationalGuest->national_finance = $this->game->nationalGuest->national_finance + $income;
        $this->game->nationalGuest->save();

        Finance::log([
            'finance_finance_text_id' => FinanceText::INCOME_TICKET,
            'finance_team_id' => $this->game->stadium->team->team_id,
            'finance_value' => $income,
            'finance_value_after' => $this->game->stadium->team->team_finance + $income,
            'finance_value_before' => $this->game->stadium->team->team_finance,
        ]);

        $this->game->stadium->team->team_finance = $this->game->stadium->team->team_finance + $income;
        $this->game->stadium->team->save();
    }

    /**
     * @return void
     */
    private function default()
    {
        $income = $this->income;
        $outcome = $this->game->stadium->stadium_maintenance;

        Finance::log([
            'finance_financetext_id' => FinanceText::INCOME_TICKET,
            'finance_team_id' => $this->game->teamHome->team_id,
            'finance_value' => $income,
            'finance_value_after' => $this->game->teamHome->team_finance + $income,
            'finance_value_before' => $this->game->teamHome->team_finance,
        ]);

        Finance::log([
            'finance_financetext_id' => FinanceText::OUTCOME_GAME,
            'finance_team_id' => $this->game->teamHome->team_id,
            'finance_value' => -$this->game->stadium->stadium_maintenance,
            'finance_value_after' => $this->game->teamHome->team_finance + $income - $outcome,
            'finance_value_before' => $this->game->teamHome->team_finance + $income,
        ]);

        $this->game->teamHome->team_finance = $this->game->teamHome->team_finance + $income - $outcome;
        $this->game->teamHome->save();
    }
}