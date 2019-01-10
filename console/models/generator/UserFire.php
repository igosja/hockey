<?php

namespace console\models\generator;

use common\models\Team;
use Exception;

/**
 * Class UserFire
 * @package console\models\generator
 */
class UserFire
{
    /**
     * @throws Exception
     * @return void
     */
    public function execute()
    {
        $teamArray = Team::find()
            ->joinWith(['manager'])
            ->where(['user_holiday' => 0])
            ->andWhere(['!=', 'team_user_id', 0])
            ->andWhere(['<', 'user_date_vip', time()])
            ->andWhere(['>=', 'team_auto', Team::MAX_AUTO_GAMES])
            ->orderBy(['team_id' => SORT_ASC])
            ->each();
        foreach ($teamArray as $team) {
            /**
             * @var Team $team
             */
            $team->managerFire();
        }

        $teamArray = Team::find()
            ->joinWith(['manager'])
            ->where(['user_holiday' => 0])
            ->andWhere(['!=', 'team_user_id', 0])
            ->andWhere(['<', 'user_date_vip', time()])
            ->andWhere(['<', 'user_date_login', time() - 1296000])//15 днів для не VIP
            ->orderBy(['team_id' => SORT_ASC])
            ->each();
        foreach ($teamArray as $team) {
            /**
             * @var Team $team
             */
            $team->managerFire();
        }

        $teamArray = Team::find()
            ->joinWith(['manager'])
            ->where(['user_holiday' => 0])
            ->andWhere(['!=', 'team_user_id', 0])
            ->andWhere(['>=', 'user_date_vip', time()])
            ->andWhere(['<', 'user_date_login', time() - 5184000])//60 днів для VIP
            ->orderBy(['team_id' => SORT_ASC])
            ->each();
        foreach ($teamArray as $team) {
            /**
             * @var Team $team
             */
            $team->managerFire();
        }
    }
}
