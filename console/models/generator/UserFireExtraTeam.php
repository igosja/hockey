<?php

namespace console\models\generator;

use common\models\History;
use common\models\HistoryText;
use common\models\Team;
use Exception;

/**
 * Class UserFireExtraTeam
 * @package console\models\generator
 */
class UserFireExtraTeam
{
    /**
     * @throws Exception
     * @return void
     */
    public function execute()
    {
        $userArray = Team::find()
            ->joinWith(['manager'])
            ->where(['user_holiday' => 0])
            ->andWhere(['!=', 'team_user_id', 0])
            ->andWhere(['<', 'user_date_vip', time()])
            ->groupBy(['team_user_id'])
            ->having(['>', 'COUNT(team_id)', 1])
            ->orderBy(['team_id' => SORT_ASC])
            ->each();
        foreach ($userArray as $user) {
            /**
             * @var Team $user
             */
            $limit = count($user->manager->team) - 1;

            $teamArray = Team::find()
                ->join(
                    'LEFT JOIN',
                    History::tableName(),
                    '`history_team_id`=`team_id` AND `history_user_id`=`team_user_id`'
                )
                ->where([
                    'team_user_id' => $user->team_user_id,
                    'history_history_text_id' => HistoryText::USER_MANAGER_TEAM_IN
                ])
                ->groupBy(['team_id'])
                ->orderBy('MAX(history_id) DESC')
                ->limit($limit)
                ->all();
            foreach ($teamArray as $team) {
                $team->managerFire();
            }
        }

        $userArray = Team::find()
            ->joinWith(['manager'])
            ->where(['user_holiday' => 0])
            ->andWhere(['!=', 'team_user_id', 0])
            ->andWhere(['>=', 'user_date_vip', time()])
            ->groupBy(['team_user_id'])
            ->having(['>', 'COUNT(team_id)', 1])
            ->orderBy(['team_id' => SORT_ASC])
            ->each();
        foreach ($userArray as $user) {
            /**
             * @var Team $user
             */
            $limit = count($user->manager->team) - 2;

            $teamArray = Team::find()
                ->join(
                    'LEFT JOIN',
                    History::tableName(),
                    '`history_team_id`=`team_id` AND `history_user_id`=`team_user_id`'
                )
                ->where([
                    'team_user_id' => $user->team_user_id,
                    'history_history_text_id' => HistoryText::USER_MANAGER_TEAM_IN
                ])
                ->groupBy(['team_id'])
                ->orderBy('MAX(history_id) DESC')
                ->limit($limit)
                ->all();
            foreach ($teamArray as $team) {
                $team->managerFire();
            }
        }
    }
}
