<?php

namespace console\models\generator;

use common\models\Position;
use common\models\Season;
use common\models\Special;
use Yii;

/**
 * Class Snapshot
 * @package console\models\generator
 */
class Snapshot
{
    /**
     * @throws \yii\db\Exception
     * @return void
     */
    public function execute()
    {
        $seasonId = Season::getCurrentSeason();

        $sql = "INSERT INTO `snapshot`
                SET `snapshot_base`=(SELECT AVG(`base_level`) FROM `team` LEFT JOIN `base` ON `team_base_id` = `base_id` WHERE `team_id`!=0),
                    `snapshot_base_total`=(SELECT AVG(`base_level` + `base_medical_level` + `base_physical_level` + `base_school_level` + `base_scout_level` + `base_training_level`) FROM `team` LEFT JOIN `base` ON `team_base_id` = `base_id` LEFT JOIN `base_medical` ON `team_base_medical_id` = `base_medical_id` LEFT JOIN `base_physical` ON `team_base_physical_id` = `base_physical_id` LEFT JOIN `base_school` ON `team_base_school_id` = `base_school_id` LEFT JOIN `base_scout` ON `team_base_scout_id` = `base_scout_id` LEFT JOIN `base_training` ON `team_base_training_id` = `base_training_id` WHERE `team_id`!=0),
                    `snapshot_base_medical`=(SELECT AVG(`base_medical_level`) FROM `team` LEFT JOIN `base_medical` ON `team_base_medical_id` = `base_medical_id` WHERE `team_id`!=0),
                    `snapshot_base_physical`=(SELECT AVG(`base_physical_level`) FROM `team` LEFT JOIN `base_physical` ON `team_base_physical_id` = `base_physical_id` WHERE `team_id`!=0),
                    `snapshot_base_school`=(SELECT AVG(`base_school_level`) FROM `team` LEFT JOIN `base_school` ON `team_base_school_id` = `base_school_id` WHERE `team_id`!=0),
                    `snapshot_base_scout`=(SELECT AVG(`base_scout_level`) FROM `team` LEFT JOIN `base_scout` ON `team_base_scout_id` = `base_scout_id` WHERE `team_id`!=0),
                    `snapshot_base_training`=(SELECT AVG(`base_training_level`) FROM `team` LEFT JOIN `base_training` ON `team_base_training_id` = `base_training_id` WHERE `team_id`!=0),
                    `snapshot_bot`=(SELECT COUNT(`bot_id`) FROM `bot`),
                    `snapshot_country`=(SELECT COUNT(`city_id`) FROM (SELECT `city_id` FROM `city` WHERE `city_country_id` != 0 GROUP BY `city_country_id`) AS `t`),
                    `snapshot_date`=UNIX_TIMESTAMP(),
                    `snapshot_manager`=(SELECT COUNT(`user_id`) FROM `user` WHERE `user_date_login`>UNIX_TIMESTAMP()-604800),
                    `snapshot_manager_vip_percent`=(SELECT COUNT(`user_id`) FROM `user` WHERE `user_date_login`>UNIX_TIMESTAMP()-604800 AND `user_date_vip`>UNIX_TIMESTAMP())/(SELECT COUNT(`user_id`) FROM `user` WHERE `user_date_login`>UNIX_TIMESTAMP()-604800)*100,
                    `snapshot_manager_with_team`=(SELECT COUNT(`count`) FROM (SELECT COUNT(`team_id`) AS `count` FROM `team` WHERE `team_user_id`!=0 GROUP BY `team_user_id`) AS `t`),
                    `snapshot_player`=(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0),
                    `snapshot_player_age`=(SELECT AVG(`player_age`) FROM `player` WHERE `player_team_id`!=0),
                    `snapshot_player_c`=(SELECT COUNT(`player_id`) FROM `player` LEFT JOIN `player_position` ON `player_id`=`player_position_player_id` WHERE `player_team_id`!=0 AND `player_position_position_id`=" . Position::CF . ")/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
                    `snapshot_player_gk`=(SELECT COUNT(`player_id`) FROM `player` LEFT JOIN `player_position` ON `player_id`=`player_position_player_id` WHERE `player_team_id`!=0 AND `player_position_position_id`=" . Position::GK . ")/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
                    `snapshot_player_in_team`=(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)/(SELECT COUNT(`team_id`) FROM `team` WHERE `team_id`!=0),
                    `snapshot_player_ld`=(SELECT COUNT(`player_id`) FROM `player` LEFT JOIN `player_position` ON `player_id`=`player_position_player_id` WHERE `player_team_id`!=0 AND `player_position_position_id`=" . Position::LD . ")/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
                    `snapshot_player_lw`=(SELECT COUNT(`player_id`) FROM `player` LEFT JOIN `player_position` ON `player_id`=`player_position_player_id` WHERE `player_team_id`!=0 AND `player_position_position_id`=" . Position::LW . ")/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
                    `snapshot_player_rd`=(SELECT COUNT(`player_id`) FROM `player` LEFT JOIN `player_position` ON `player_id`=`player_position_player_id` WHERE `player_team_id`!=0 AND `player_position_position_id`=" . Position::RD . ")/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
                    `snapshot_player_rw`=(SELECT COUNT(`player_id`) FROM `player` LEFT JOIN `player_position` ON `player_id`=`player_position_player_id` WHERE `player_team_id`!=0 AND `player_position_position_id`=" . Position::RW . ")/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
                    `snapshot_player_power`=(SELECT AVG(`player_power_nominal`) FROM `player` WHERE `player_team_id`!=0),
                    `snapshot_player_special_percent_no`=(SELECT COUNT(`player_id`) FROM (SELECT `player_id` FROM `player` LEFT JOIN `player_special` ON `player_id`=`player_special_player_id` WHERE `player_team_id`!=0 AND `player_special_player_id` IS NULL GROUP BY `player_id`) AS `t`)/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
                    `snapshot_player_special_percent_one`=(SELECT COUNT(`player_id`) FROM (SELECT `player_id` FROM `player` LEFT JOIN `player_special` ON `player_id`=`player_special_player_id` WHERE `player_team_id`!=0 GROUP BY `player_id` HAVING COUNT(`player_special_player_id`)=1) AS `t`)/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
                    `snapshot_player_special_percent_two`=(SELECT COUNT(`player_id`) FROM (SELECT `player_id` FROM `player` LEFT JOIN `player_special` ON `player_id`=`player_special_player_id` WHERE `player_team_id`!=0 GROUP BY `player_id` HAVING COUNT(`player_special_player_id`)=2) AS `t`)/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
                    `snapshot_player_special_percent_three`=(SELECT COUNT(`player_id`) FROM (SELECT `player_id` FROM `player` LEFT JOIN `player_special` ON `player_id`=`player_special_player_id` WHERE `player_team_id`!=0 GROUP BY `player_id` HAVING COUNT(`player_special_player_id`)=3) AS `t`)/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
                    `snapshot_player_special_percent_four`=(SELECT COUNT(`player_id`) FROM (SELECT `player_id` FROM `player` LEFT JOIN `player_special` ON `player_id`=`player_special_player_id` WHERE `player_team_id`!=0 GROUP BY `player_id` HAVING COUNT(`player_special_player_id`)=4) AS `t`)/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
                    `snapshot_player_special_percent_athletic`=(SELECT COUNT(`player_id`) FROM (SELECT `player_id` FROM `player` LEFT JOIN `player_special` ON `player_id`=`player_special_player_id` WHERE `player_team_id`!=0 AND `player_special_special_id`=" . Special::ATHLETIC . " GROUP BY `player_id`) AS `t`)/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
                    `snapshot_player_special_percent_combine`=(SELECT COUNT(`player_id`) FROM (SELECT `player_id` FROM `player` LEFT JOIN `player_special` ON `player_id`=`player_special_player_id` WHERE `player_team_id`!=0 AND `player_special_special_id`=" . Special::COMBINE . " GROUP BY `player_id`) AS `t`)/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
                    `snapshot_player_special_percent_idol`=(SELECT COUNT(`player_id`) FROM (SELECT `player_id` FROM `player` LEFT JOIN `player_special` ON `player_id`=`player_special_player_id` WHERE `player_team_id`!=0 AND `player_special_special_id`=" . Special::IDOL . " GROUP BY `player_id`) AS `t`)/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
                    `snapshot_player_special_percent_leader`=(SELECT COUNT(`player_id`) FROM (SELECT `player_id` FROM `player` LEFT JOIN `player_special` ON `player_id`=`player_special_player_id` WHERE `player_team_id`!=0 AND `player_special_special_id`=" . Special::LEADER . " GROUP BY `player_id`) AS `t`)/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
                    `snapshot_player_special_percent_position`=(SELECT COUNT(`player_id`) FROM (SELECT `player_id` FROM `player` LEFT JOIN `player_special` ON `player_id`=`player_special_player_id` WHERE `player_team_id`!=0 AND `player_special_special_id`=" . Special::POSITION . " GROUP BY `player_id`) AS `t`)/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
                    `snapshot_player_special_percent_power`=(SELECT COUNT(`player_id`) FROM (SELECT `player_id` FROM `player` LEFT JOIN `player_special` ON `player_id`=`player_special_player_id` WHERE `player_team_id`!=0 AND `player_special_special_id`=" . Special::POWER . " GROUP BY `player_id`) AS `t`)/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
                    `snapshot_player_special_percent_reaction`=(SELECT COUNT(`player_id`) FROM (SELECT `player_id` FROM `player` LEFT JOIN `player_special` ON `player_id`=`player_special_player_id` WHERE `player_team_id`!=0 AND `player_special_special_id`=" . Special::REACTION . " GROUP BY `player_id`) AS `t`)/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
                    `snapshot_player_special_percent_shot`=(SELECT COUNT(`player_id`) FROM (SELECT `player_id` FROM `player` LEFT JOIN `player_special` ON `player_id`=`player_special_player_id` WHERE `player_team_id`!=0 AND `player_special_special_id`=" . Special::SHOT . " GROUP BY `player_id`) AS `t`)/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
                    `snapshot_player_special_percent_speed`=(SELECT COUNT(`player_id`) FROM (SELECT `player_id` FROM `player` LEFT JOIN `player_special` ON `player_id`=`player_special_player_id` WHERE `player_team_id`!=0 AND `player_special_special_id`=" . Special::SPEED . " GROUP BY `player_id`) AS `t`)/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
                    `snapshot_player_special_percent_stick`=(SELECT COUNT(`player_id`) FROM (SELECT `player_id` FROM `player` LEFT JOIN `player_special` ON `player_id`=`player_special_player_id` WHERE `player_team_id`!=0 AND `player_special_special_id`=" . Special::STICK . " GROUP BY `player_id`) AS `t`)/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
                    `snapshot_player_special_percent_tackle`=(SELECT COUNT(`player_id`) FROM (SELECT `player_id` FROM `player` LEFT JOIN `player_special` ON `player_id`=`player_special_player_id` WHERE `player_team_id`!=0 AND `player_special_special_id`=" . Special::TACKLE . " GROUP BY `player_id`) AS `t`)/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
                    `snapshot_player_with_position_percent`=(SELECT COUNT(`player_id`) FROM (SELECT `player_id` FROM `player` LEFT JOIN `player_position` ON `player_id`=`player_position_player_id` GROUP BY `player_id` HAVING COUNT(`player_position_player_id`)=2) AS `t`)/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
                    `snapshot_season_id`=$seasonId,
                    `snapshot_team`=(SELECT COUNT(`team_id`) FROM `team` WHERE `team_id`!=0),
                    `snapshot_team_finance`=(SELECT AVG(`team_finance`) FROM `team` WHERE `team_id`!=0),
                    `snapshot_team_to_manager`=(SELECT COUNT(`team_id`) FROM `team` WHERE `team_user_id`!=0)/(SELECT COUNT(`team_id`) FROM (SELECT `team_id` FROM `team` WHERE `team_user_id`!=0 GROUP BY `team_user_id`) AS `t`),
                    `snapshot_stadium`=(SELECT AVG(`stadium_capacity`) FROM `stadium` WHERE `stadium_id`!=0)";
        Yii::$app->db->createCommand($sql)->execute();
    }
}
