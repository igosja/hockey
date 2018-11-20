<?php

namespace console\models\generator;

use common\models\Schedule;
use common\models\Stage;
use common\models\Team;
use common\models\TournamentType;

/**
 * Class MoodReset
 * @package console\models\generator
 */
class MoodReset
{
    /**
     * @return void
     */
    public function execute(): void
    {
        $check = Schedule::find()
            ->where('FROM_UNIXTIME(`schedule_date`-86400, "%Y-%m-%d")=CURDATE()')
            ->andWhere([
                'schedule_stage_id' => Stage::TOUR_1,
                'schedule_tournament_type_id' => TournamentType::CHAMPIONSHIP
            ])
            ->limit(1)
            ->one();
        if (!$check) {
            return;
        }

        Team::updateAll(['team_mood_rest' => 3, 'team_mood_super' => 3], ['!=', 'team_id', 0]);
    }
}
