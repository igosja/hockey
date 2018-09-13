<?php

namespace console\models\generator;

use Yii;

/**
 * Class CheckLineup
 * @package console\models\generator
 */
class CheckLineup
{
    /**
     * @throws \yii\db\Exception
     * @return void
     */
    public function execute(): void
    {
        $gameSql = "SELECT `game_id`
                    FROM `game`
                    LEFT JOIN `schedule`
                    ON `game_schedule_id`=`schedule_id`
                    WHERE `game_played`=0
                    AND FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()";

        $sql = "UPDATE `lineup`
                LEFT JOIN `player`
                ON `lineup_player_id`=`player_id`
                SET `lineup_player_id`=0
                WHERE `lineup_game_id` IN (" . $gameSql . ")
                AND ((`lineup_team_id`!=`player_team_id` AND `player_loan_team_id`=0)
                OR (`lineup_team_id`!=`player_loan_team_id` AND `player_loan_team_id`!=0))
                AND `lineup_team_id`!=0";
        Yii::$app->db->createCommand($sql)->execute();

        $sql = "UPDATE `lineup`
                LEFT JOIN `player`
                ON `lineup_player_id`=`player_id`
                SET `lineup_player_id`=0
                WHERE `lineup_game_id` IN (" . $gameSql . ")
                AND `lineup_national_id`!=`player_national_id`
                AND `lineup_national_id`!=0";
        Yii::$app->db->createCommand($sql)->execute();
    }
}