<?php

namespace console\models\generator;

use common\models\Stadium;
use common\models\Team;
use Yii;
use yii\db\Expression;

/**
 * Class TeamPrice
 * @package console\models\generator
 */
class TeamPrice
{
    /**
     * @throws \yii\db\Exception
     * @return void
     */
    public function execute()
    {
        $sql = "UPDATE `team`
                LEFT JOIN `stadium`
                ON `team_stadium_id`=`stadium_id`
                LEFT JOIN
                (
                    SELECT SUM(`player_price`) AS `player_price`,
                           SUM(`player_salary`) AS `player_salary`,
                           `player_team_id`
                    FROM `player`
                    GROUP BY `player_team_id`
                ) AS `t1`
                ON `player_team_id`=`team_id`
                SET `team_price_base`=(`team_base_id`-1)*500000+(`team_base_medical_id`+`team_base_physical_id`+`team_base_school_id`+`team_base_scout_id`+`team_base_training_id`-5)*250000,
                    `team_price_player`=`player_price`,
                    `team_salary`=`player_salary`,
                    `team_price_stadium`=POW(`stadium_capacity`, 1.1)*" . Stadium::ONE_SIT_PRICE_BUY . "
                WHERE `team_id`!=0";
        Yii::$app->db->createCommand($sql)->execute();

        Team::updateAll(
            ['team_price_total' => new Expression('team_price_base+team_price_player+team_price_stadium')],
            ['!=', 'team_id', 0]
        );
    }
}