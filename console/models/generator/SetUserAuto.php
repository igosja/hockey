<?php

namespace console\models\generator;

use common\models\Game;
use common\models\Team;

/**
 * Class SetUserAuto
 * @package console\models\generator
 */
class SetUserAuto
{
    /**
     * @return void
     */
    public function execute()
    {
        Team::updateAllCounters(
            ['team_auto' => 1],
            [
                'team_id' => Game::find()
                    ->select(['game_home_team_id'])
                    ->joinWith(['schedule'])
                    ->where(['game_played' => 0, 'game_home_auto' => 1])
                    ->andWhere('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ]
        );

        Team::updateAllCounters(
            ['team_auto' => 1],
            [
                'team_id' => Game::find()
                    ->select(['game_guest_team_id'])
                    ->joinWith(['schedule'])
                    ->where(['game_played' => 0, 'game_guest_auto' => 1])
                    ->andWhere('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ]
        );
        Team::updateAll(
            ['team_auto' => 0],
            [
                'team_id' => Game::find()
                    ->select(['game_home_team_id'])
                    ->joinWith(['schedule'])
                    ->where(['game_played' => 0, 'game_home_auto' => 0])
                    ->andWhere('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ]
        );

        Team::updateAll(
            ['team_auto' => 0],
            [
                'team_id' => Game::find()
                    ->select(['game_guest_team_id'])
                    ->joinWith(['schedule'])
                    ->where(['game_played' => 0, 'game_guest_auto' => 0])
                    ->andWhere('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ]
        );

        Team::updateAll(['team_auto' => 5], ['>', 'team_auto', 5]);
    }
}