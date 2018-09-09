<?php

namespace console\models\generator;

use common\models\Season;
use common\models\StatisticTeam;
use yii\db\Expression;

/**
 * Class CheckLineup
 * @package console\models\generator
 */
class UpdateTeamStatistic
{
    /**
     * @return void
     */
    public function execute(): void
    {
        StatisticTeam::updateAll(
            ['statistic_team_win_percent' => new Expression('statistic_team_win/statistic_team_game*100')],
            ['statistic_team_season_id' => Season::getCurrentSeason()]
        );
    }
}