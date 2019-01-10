<?php

namespace console\models\generator;

use common\models\Team;

/**
 * Class TeamPowerVs
 * @package console\models\generator
 */
class TeamPowerVs
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
            $team->updatePower();
        }
    }
}