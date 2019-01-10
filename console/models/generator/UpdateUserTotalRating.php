<?php

namespace console\models\generator;

use common\models\Season;
use Yii;

/**
 * Class UpdateUserTotalRating
 * @package console\models\generator
 */
class UpdateUserTotalRating
{
    /**
     * @throws \yii\db\Exception
     * @return void
     */
    public function execute()
    {
        $seasonId = Season::getCurrentSeason();

        $sql = "UPDATE `user_rating`
                LEFT JOIN
                (
                    SELECT SUM(`user_rating_auto`) AS `user_rating_auto_total`,
                           SUM(`user_rating_collision_loose`) AS `user_rating_collision_loose_total`,
                           SUM(`user_rating_collision_win`) AS `user_rating_collision_win_total`,
                           SUM(`user_rating_game`) AS `user_rating_game_total`,
                           SUM(`user_rating_loose`) AS `user_rating_loose_total`,
                           SUM(`user_rating_loose_equal`) AS `user_rating_loose_equal_total`,
                           SUM(`user_rating_loose_strong`) AS `user_rating_loose_strong_total`,
                           SUM(`user_rating_loose_super`) AS `user_rating_loose_super_total`,
                           SUM(`user_rating_loose_weak`) AS `user_rating_loose_weak_total`,
                           SUM(`user_rating_loose_overtime`) AS `user_rating_loose_overtime_total`,
                           SUM(`user_rating_loose_overtime_equal`) AS `user_rating_loose_overtime_equal_total`,
                           SUM(`user_rating_loose_overtime_strong`) AS `user_rating_loose_overtime_strong_total`,
                           SUM(`user_rating_loose_overtime_weak`) AS `user_rating_loose_overtime_weak_total`,
                           `user_rating_user_id` AS `user_rating_user_id_total`,
                           SUM(`user_rating_vs_super`) AS `user_rating_vs_super_total`,
                           SUM(`user_rating_vs_rest`) AS `user_rating_vs_rest_total`,
                           SUM(`user_rating_win`) AS `user_rating_win_total`,
                           SUM(`user_rating_win_equal`) AS `user_rating_win_equal_total`,
                           SUM(`user_rating_win_strong`) AS `user_rating_win_strong_total`,
                           SUM(`user_rating_win_super`) AS `user_rating_win_super_total`,
                           SUM(`user_rating_win_weak`) AS `user_rating_win_weak_total`,
                           SUM(`user_rating_win_overtime`) AS `user_rating_win_overtime_total`,
                           SUM(`user_rating_win_overtime_equal`) AS `user_rating_win_overtime_equal_total`,
                           SUM(`user_rating_win_overtime_strong`) AS `user_rating_win_overtime_strong_total`,
                           SUM(`user_rating_win_overtime_weak`) AS `user_rating_win_overtime_weak_total`
                    FROM `user_rating`
                    WHERE `user_rating_season_id`!=0
                    GROUP BY `user_rating_user_id`
                ) AS `t1`
                ON `user_rating_user_id`=`user_rating_user_id_total`
                SET `user_rating_auto`=`user_rating_auto_total`,
                    `user_rating_collision_loose`=`user_rating_collision_loose_total`,
                    `user_rating_collision_win`=`user_rating_collision_win_total`,
                    `user_rating_game`=`user_rating_game_total`,
                    `user_rating_loose`=`user_rating_loose_total`,
                    `user_rating_loose_equal`=`user_rating_loose_equal_total`,
                    `user_rating_loose_strong`=`user_rating_loose_strong_total`,
                    `user_rating_loose_super`=`user_rating_loose_super_total`,
                    `user_rating_loose_weak`=`user_rating_loose_weak_total`,
                    `user_rating_loose_overtime`=`user_rating_loose_overtime_total`,
                    `user_rating_loose_overtime_equal`=`user_rating_loose_overtime_equal_total`,
                    `user_rating_loose_overtime_strong`=`user_rating_loose_overtime_strong_total`,
                    `user_rating_loose_overtime_weak`=`user_rating_loose_overtime_weak_total`,
                    `user_rating_vs_super`=`user_rating_vs_super_total`,
                    `user_rating_vs_rest`=`user_rating_vs_rest_total`,
                    `user_rating_win`=`user_rating_win_total`,
                    `user_rating_win_equal`=`user_rating_win_equal_total`,
                    `user_rating_win_strong`=`user_rating_win_strong_total`,
                    `user_rating_win_super`=`user_rating_win_super_total`,
                    `user_rating_win_weak`=`user_rating_win_weak_total`,
                    `user_rating_win_overtime`=`user_rating_win_overtime_total`,
                    `user_rating_win_overtime_equal`=`user_rating_win_overtime_equal_total`,
                    `user_rating_win_overtime_strong`=`user_rating_win_overtime_strong_total`,
                    `user_rating_win_overtime_weak`=`user_rating_win_overtime_weak_total`
                WHERE `user_rating_season_id`=0";
        Yii::$app->db->createCommand($sql)->execute();

        $sql = "UPDATE `user_rating`
                SET `user_rating_rating`=500
                    -`user_rating_auto`*0.5
                    -`user_rating_collision_loose`*3
                    +`user_rating_collision_win`*3.3
                    +`user_rating_game`*0.01
                    -`user_rating_loose_equal`*3
                    -`user_rating_loose_strong`*1
                    -`user_rating_loose_super`*5
                    -`user_rating_loose_weak`*5
                    -`user_rating_loose_overtime_equal`*1
                    -`user_rating_loose_overtime_weak`*2
                    +`user_rating_vs_super`*1.1
                    -`user_rating_vs_rest`*1
                    +`user_rating_win_equal`*3.3
                    +`user_rating_win_strong`*5.5
                    +`user_rating_win_super`*5.5
                    +`user_rating_win_weak`*1.1
                    +`user_rating_win_overtime_equal`*1.1
                    +`user_rating_win_overtime_strong`*2.2
                WHERE `user_rating_season_id`=$seasonId";
        Yii::$app->db->createCommand($sql)->execute();

        $sql = "UPDATE `user_rating`
                LEFT JOIN
                (
                    SELECT `user_rating_rating`-500 AS `user_rating_rating_100`,
                           `user_rating_user_id` AS `user_rating_user_id_100`
                    FROM `user_rating`
                    WHERE `user_rating_season_id`=$seasonId
                    AND `user_rating_season_id`!=0
                ) AS `t1`
                ON `user_rating_user_id`=`user_rating_user_id_100`
                LEFT JOIN
                (
                    SELECT ROUND((`user_rating_rating`-500)*0.75, 2) AS `user_rating_rating_75`,
                           `user_rating_user_id` AS `user_rating_user_id_75`
                    FROM `user_rating`
                    WHERE `user_rating_season_id`=$seasonId-1
                    AND `user_rating_season_id`!=0
                ) AS `t2`
                ON `user_rating_user_id`=`user_rating_user_id_75`
                LEFT JOIN
                (
                    SELECT ROUND((`user_rating_rating`-500)*0.5, 2) AS `user_rating_rating_50`,
                           `user_rating_user_id` AS `user_rating_user_id_50`
                    FROM `user_rating`
                    WHERE `user_rating_season_id`=$seasonId-2
                    AND `user_rating_season_id`!=0
                ) AS `t3`
                ON `user_rating_user_id`=`user_rating_user_id_50`
                LEFT JOIN
                (
                    SELECT ROUND((`user_rating_rating`-500)*0.25, 2) AS `user_rating_rating_25`,
                           `user_rating_user_id` AS `user_rating_user_id_25`
                    FROM `user_rating`
                    WHERE `user_rating_season_id`=$seasonId-3
                    AND `user_rating_season_id`!=0
                ) AS `t4`
                ON `user_rating_user_id`=`user_rating_user_id_25`
                SET `user_rating_rating`=500+IFNULL(`user_rating_rating_100`, 0)+IFNULL(`user_rating_rating_75`, 0)+IFNULL(`user_rating_rating_50`, 0)+IFNULL(`user_rating_rating_25`, 0)
                WHERE `user_rating_season_id`=0";
        Yii::$app->db->createCommand($sql)->execute();

        $sql = "UPDATE `user`
                LEFT JOIN `user_rating`
                ON `user_id`=`user_rating_user_id`
                SET `user_rating`=IFNULL(`user_rating_rating`, 500)
                WHERE `user_id`!=0
                AND `user_rating_season_id`=0";
        Yii::$app->db->createCommand($sql)->execute();
    }
}