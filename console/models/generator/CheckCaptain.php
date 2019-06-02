<?php

namespace console\models\generator;

use common\models\Game;
use common\models\Lineup;
use common\models\Position;
use common\models\Schedule;
use common\models\TournamentType;
use Exception;

/**
 * Class CheckCaptain
 * @package console\models\generator
 */
class CheckCaptain
{
    /**
     * @return void
     *@throws Exception
     */
    public function execute()
    {
        $schedule = Schedule::find()
            ->where('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->limit(1)
            ->one();
        if (TournamentType::NATIONAL == $schedule->tournamentType->tournament_type_id) {
            $groupBy = 'lineup_national_id';
        } else {
            $groupBy = 'lineup_team_id';
        }
        $lineupArray = Lineup::find()
            ->select([$groupBy, 'lineup_game_id'])
            ->where([
                'lineup_game_id' => Game::find()
                    ->select(['game_id'])
                    ->where(['game_schedule_id' => $schedule->schedule_id])
            ])
            ->having('SUM(lineup_captain)!=1')
            ->groupBy([$groupBy, 'lineup_game_id'])
            ->each(5);
        foreach ($lineupArray as $lineup) {
            /**
             * @var Lineup $lineup
             */
            Lineup::updateAll(
                ['lineup_captain' => 0],
                ['lineup_game_id' => $lineup->lineup_game_id, $groupBy => $lineup->$groupBy]
            );

            $lineupUpdate = Lineup::find()
                ->where(['lineup_game_id' => $lineup->lineup_game_id, $groupBy => $lineup->$groupBy])
                ->andWhere(['!=', 'lineup_position_id', Position::GK])
                ->orderBy('RAND()')
                ->limit(1)
                ->one();
            $lineupUpdate->lineup_captain = 1;
            $lineupUpdate->save(true, ['lineup_captain']);
        }
    }
}
