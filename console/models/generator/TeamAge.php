<?php

namespace console\models\generator;

use Yii;

/**
 * Class TeamAge
 * @package console\models\generator
 */
class TeamAge
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
                    SELECT AVG(`player_age`) AS `player_age`, `player_team_id`
                    FROM `player`
                    WHERE `player_team_id`!=0
                    GROUP BY `player_team_id`
                ) AS `t1`
                ON `player_team_id`=`team_id`
                SET `team_age`=`player_age`
                WHERE `team_id`!=0";
        Yii::$app->db->createCommand($sql)->execute();
    }
}