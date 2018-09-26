<?php

namespace console\models\generator;

use Yii;

/**
 * Class TeamPlayerCount
 * @package console\models\generator
 */
class TeamPlayerCount
{
    /**
     * @throws \yii\db\Exception
     * @return void
     */
    public function execute(): void
    {
        $sql = "UPDATE `team`
                LEFT JOIN
                (
                    SELECT COUNT(`player_id`) AS `count_player`, `player_team_id`
                    FROM `player`
                    WHERE `player_team_id`!=0
                    GROUP BY `player_team_id`
                ) AS `t1`
                ON `player_team_id`=`team_id`
                SET `team_player`=`count_player`
                WHERE `team_id`!=0";
        Yii::$app->db->createCommand($sql)->execute();
    }
}