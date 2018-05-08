<?php

include(__DIR__ . '/include/include.php');

$sql = "INSERT INTO `snapshot`
        SET `snapshot_base`=(SELECT AVG(`base_level`) FROM `team` LEFT JOIN `base` ON `team_base_id` = `base_id` WHERE `team_id`!=0),
            `snapshot_base_total`=(SELECT AVG(`base_level` + `basemedical_level` + `basephisical_level` + `baseschool_level` + `basescout_level` + `basetraining_level`) FROM `team` LEFT JOIN `base` ON `team_base_id` = `base_id` LEFT JOIN `basemedical` ON `team_basemedical_id` = `basemedical_id` LEFT JOIN `basephisical` ON `team_basephisical_id` = `basephisical_id` LEFT JOIN `baseschool` ON `team_baseschool_id` = `baseschool_id` LEFT JOIN `basescout` ON `team_basescout_id` = `basescout_id` LEFT JOIN `basetraining` ON `team_basetraining_id` = `basetraining_id` WHERE `team_id`!=0),
            `snapshot_basemedical`=(SELECT AVG(`basemedical_level`) FROM `team` LEFT JOIN `basemedical` ON `team_basemedical_id` = `basemedical_id` WHERE `team_id`!=0),
            `snapshot_basephisical`=(SELECT AVG(`basephisical_level`) FROM `team` LEFT JOIN `basephisical` ON `team_basephisical_id` = `basephisical_id` WHERE `team_id`!=0),
            `snapshot_baseschool`=(SELECT AVG(`baseschool_level`) FROM `team` LEFT JOIN `baseschool` ON `team_baseschool_id` = `baseschool_id` WHERE `team_id`!=0),
            `snapshot_basescout`=(SELECT AVG(`basescout_level`) FROM `team` LEFT JOIN `basescout` ON `team_basescout_id` = `basescout_id` WHERE `team_id`!=0),
            `snapshot_basetraining`=(SELECT AVG(`basetraining_level`) FROM `team` LEFT JOIN `basetraining` ON `team_basetraining_id` = `basetraining_id` WHERE `team_id`!=0),
            `snapshot_country`=(SELECT COUNT(`city_id`) FROM (SELECT `city_id` FROM `city` WHERE `city_country_id` != 0 GROUP BY `city_country_id`) AS `t`),
            `snapshot_date`=UNIX_TIMESTAMP(),
            `snapshot_manager`=(SELECT COUNT(`user_id`) FROM `user` WHERE `user_date_login`>UNIX_TIMESTAMP()-604800),
            `snapshot_manager_vip_percent`=(SELECT COUNT(`user_id`) FROM `user` WHERE `user_date_login`>UNIX_TIMESTAMP()-604800 AND `user_date_vip`>UNIX_TIMESTAMP())/(SELECT COUNT(`user_id`) FROM `user` WHERE `user_date_login`>UNIX_TIMESTAMP()-604800)*100,
            `snapshot_manager_with_team`=(SELECT COUNT(`count`) FROM (SELECT COUNT(`team_id`) AS `count` FROM `team` WHERE `team_user_id`!=0 GROUP BY `team_user_id`) AS `t`),
            `snapshot_player`=(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0),
            `snapshot_player_age`=(SELECT AVG(`player_age`) FROM `player` WHERE `player_team_id`!=0),
            `snapshot_player_c`=(SELECT COUNT(`player_id`) FROM `player` LEFT JOIN `playerposition` ON `player_id`=`playerposition_player_id` WHERE `player_team_id`!=0 AND `playerposition_position_id`=" . POSITION_C . ")/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
            `snapshot_player_gk`=(SELECT COUNT(`player_id`) FROM `player` LEFT JOIN `playerposition` ON `player_id`=`playerposition_player_id` WHERE `player_team_id`!=0 AND `playerposition_position_id`=" . POSITION_GK . ")/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
            `snapshot_player_in_team`=(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)/(SELECT COUNT(`team_id`) FROM `team` WHERE `team_id`!=0),
            `snapshot_player_ld`=(SELECT COUNT(`player_id`) FROM `player` LEFT JOIN `playerposition` ON `player_id`=`playerposition_player_id` WHERE `player_team_id`!=0 AND `playerposition_position_id`=" . POSITION_LD . ")/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
            `snapshot_player_lw`=(SELECT COUNT(`player_id`) FROM `player` LEFT JOIN `playerposition` ON `player_id`=`playerposition_player_id` WHERE `player_team_id`!=0 AND `playerposition_position_id`=" . POSITION_LW . ")/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
            `snapshot_player_rd`=(SELECT COUNT(`player_id`) FROM `player` LEFT JOIN `playerposition` ON `player_id`=`playerposition_player_id` WHERE `player_team_id`!=0 AND `playerposition_position_id`=" . POSITION_RD . ")/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
            `snapshot_player_rw`=(SELECT COUNT(`player_id`) FROM `player` LEFT JOIN `playerposition` ON `player_id`=`playerposition_player_id` WHERE `player_team_id`!=0 AND `playerposition_position_id`=" . POSITION_RW . ")/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
            `snapshot_player_power`=(SELECT AVG(`player_power_nominal`) FROM `player` WHERE `player_team_id`!=0),
            `snapshot_player_special_percent_no`=(SELECT COUNT(`player_id`) FROM (SELECT `player_id` FROM `player` LEFT JOIN `playerspecial` ON `player_id`=`playerspecial_player_id` WHERE `player_team_id`!=0 AND `playerspecial_player_id` IS NULL GROUP BY `player_id`) AS `t`)/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
            `snapshot_player_special_percent_one`=(SELECT COUNT(`player_id`) FROM (SELECT `player_id` FROM `player` LEFT JOIN `playerspecial` ON `player_id`=`playerspecial_player_id` WHERE `player_team_id`!=0 GROUP BY `player_id` HAVING COUNT(`playerspecial_player_id`)=1) AS `t`)/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
            `snapshot_player_special_percent_two`=(SELECT COUNT(`player_id`) FROM (SELECT `player_id` FROM `player` LEFT JOIN `playerspecial` ON `player_id`=`playerspecial_player_id` WHERE `player_team_id`!=0 GROUP BY `player_id` HAVING COUNT(`playerspecial_player_id`)=2) AS `t`)/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
            `snapshot_player_special_percent_three`=(SELECT COUNT(`player_id`) FROM (SELECT `player_id` FROM `player` LEFT JOIN `playerspecial` ON `player_id`=`playerspecial_player_id` WHERE `player_team_id`!=0 GROUP BY `player_id` HAVING COUNT(`playerspecial_player_id`)=3) AS `t`)/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
            `snapshot_player_special_percent_four`=(SELECT COUNT(`player_id`) FROM (SELECT `player_id` FROM `player` LEFT JOIN `playerspecial` ON `player_id`=`playerspecial_player_id` WHERE `player_team_id`!=0 GROUP BY `player_id` HAVING COUNT(`playerspecial_player_id`)=4) AS `t`)/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
            `snapshot_player_special_percent_athletic`=(SELECT COUNT(`player_id`) FROM (SELECT `player_id` FROM `player` LEFT JOIN `playerspecial` ON `player_id`=`playerspecial_player_id` WHERE `player_team_id`!=0 AND `playerspecial_special_id`=" . SPECIAL_ATHLETIC . " GROUP BY `player_id`) AS `t`)/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
            `snapshot_player_special_percent_combine`=(SELECT COUNT(`player_id`) FROM (SELECT `player_id` FROM `player` LEFT JOIN `playerspecial` ON `player_id`=`playerspecial_player_id` WHERE `player_team_id`!=0 AND `playerspecial_special_id`=" . SPECIAL_COMBINE . " GROUP BY `player_id`) AS `t`)/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
            `snapshot_player_special_percent_idol`=(SELECT COUNT(`player_id`) FROM (SELECT `player_id` FROM `player` LEFT JOIN `playerspecial` ON `player_id`=`playerspecial_player_id` WHERE `player_team_id`!=0 AND `playerspecial_special_id`=" . SPECIAL_IDOL . " GROUP BY `player_id`) AS `t`)/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
            `snapshot_player_special_percent_leader`=(SELECT COUNT(`player_id`) FROM (SELECT `player_id` FROM `player` LEFT JOIN `playerspecial` ON `player_id`=`playerspecial_player_id` WHERE `player_team_id`!=0 AND `playerspecial_special_id`=" . SPECIAL_LEADER . " GROUP BY `player_id`) AS `t`)/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
            `snapshot_player_special_percent_power`=(SELECT COUNT(`player_id`) FROM (SELECT `player_id` FROM `player` LEFT JOIN `playerspecial` ON `player_id`=`playerspecial_player_id` WHERE `player_team_id`!=0 AND `playerspecial_special_id`=" . SPECIAL_POWER . " GROUP BY `player_id`) AS `t`)/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
            `snapshot_player_special_percent_reaction`=(SELECT COUNT(`player_id`) FROM (SELECT `player_id` FROM `player` LEFT JOIN `playerspecial` ON `player_id`=`playerspecial_player_id` WHERE `player_team_id`!=0 AND `playerspecial_special_id`=" . SPECIAL_REACTION . " GROUP BY `player_id`) AS `t`)/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
            `snapshot_player_special_percent_shot`=(SELECT COUNT(`player_id`) FROM (SELECT `player_id` FROM `player` LEFT JOIN `playerspecial` ON `player_id`=`playerspecial_player_id` WHERE `player_team_id`!=0 AND `playerspecial_special_id`=" . SPECIAL_SHOT . " GROUP BY `player_id`) AS `t`)/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
            `snapshot_player_special_percent_speed`=(SELECT COUNT(`player_id`) FROM (SELECT `player_id` FROM `player` LEFT JOIN `playerspecial` ON `player_id`=`playerspecial_player_id` WHERE `player_team_id`!=0 AND `playerspecial_special_id`=" . SPECIAL_SPEED . " GROUP BY `player_id`) AS `t`)/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
            `snapshot_player_special_percent_tackle`=(SELECT COUNT(`player_id`) FROM (SELECT `player_id` FROM `player` LEFT JOIN `playerspecial` ON `player_id`=`playerspecial_player_id` WHERE `player_team_id`!=0 AND `playerspecial_special_id`=" . SPECIAL_TACKLE . " GROUP BY `player_id`) AS `t`)/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
            `snapshot_player_with_position_percent`=(SELECT COUNT(`player_id`) FROM (SELECT `player_id` FROM `player` LEFT JOIN `playerposition` ON `player_id`=`playerposition_player_id` GROUP BY `player_id` HAVING COUNT(`playerposition_player_id`)=2) AS `t`)/(SELECT COUNT(`player_id`) FROM `player` WHERE `player_team_id`!=0)*100,
            `snapshot_season_id`=$igosja_season_id,
            `snapshot_team`=(SELECT COUNT(`team_id`) FROM `team` WHERE `team_id`!=0),
            `snapshot_team_finance`=(SELECT AVG(`team_finance`) FROM `team` WHERE `team_id`!=0),
            `snapshot_team_to_manager`=(SELECT COUNT(`team_id`) FROM `team` WHERE `team_user_id`!=0)/(SELECT COUNT(`team_id`) FROM (SELECT `team_id` FROM `team` WHERE `team_user_id`!=0 GROUP BY `team_user_id`) AS `t`),
            `snapshot_stadium`=(SELECT AVG(`stadium_capacity`) FROM `stadium` WHERE `stadium_id`!=0)";
f_igosja_mysqli_query($sql);

if ($num_get = (int) f_igosja_request_get('num'))
{
    setcookie('user_referrer_id', $num_get, time() + 31536000); //365 днів

    redirect('/');
}

$sql = "SELECT `news_text`,
               `news_title`,
               `user_id`,
               `user_login`
        FROM `news`
        LEFT JOIN `user`
        ON `news_user_id`=`user_id`
        WHERE `news_country_id`=0
        ORDER BY `news_id` DESC
        LIMIT 1";
$news_sql = f_igosja_mysqli_query($sql);

$news_array = $news_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `country_name`,
               `division_name`,
               `review_id`,
               `review_title`,
               `stage_name`,
               `user_id`,
               `user_login`
        FROM `review`
        LEFT JOIN `country`
        ON `review_country_id`=`country_id`
        LEFT JOIN `division`
        ON `review_division_id`=`division_id`
        LEFT JOIN `stage`
        ON `review_stage_id`=`stage_id`
        LEFT JOIN `user`
        ON `review_user_id`=`user_id`
        ORDER BY `review_id` DESC
        LIMIT 10";
$review_sql = f_igosja_mysqli_query($sql);

$review_array = $review_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `country_id`,
               `country_name`,
               `news_text`,
               `news_title`,
               `user_id`,
               `user_login`
        FROM `news`
        LEFT JOIN `user`
        ON `news_user_id`=`user_id`
        LEFT JOIN `country`
        ON `news_country_id`=`country_id`
        WHERE `news_country_id`!=0
        ORDER BY `news_id` DESC
        LIMIT 1";
$newscountry_sql = f_igosja_mysqli_query($sql);

$newscountry_array = $newscountry_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `user_birth_year`,
               `user_id`,
               `user_login`,
               `user_name`,
               `user_surname`
        FROM `user`
        WHERE `user_birth_day`=FROM_UNIXTIME(UNIX_TIMESTAMP(), '%e')
        AND `user_birth_month`=FROM_UNIXTIME(UNIX_TIMESTAMP(), '%c')
        AND `user_date_confirm`!=0
        AND `user_date_login`>UNIX_TIMESTAMP()-2592000
        AND `user_id`!=0
        ORDER BY `user_id` ASC";
$birth_sql = f_igosja_mysqli_query($sql);

$birth_array = $birth_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `forumgroup_name`,
               `forumtheme_id`,
               `forumtheme_name`,
               CEIL(`forumtheme_count_message`/20) AS `last_page`
        FROM `forumtheme`
        LEFT JOIN `forumgroup`
        ON `forumtheme_forumgroup_id`=`forumgroup_id`
        WHERE `forumgroup_forumchapter_id`!=4
        ORDER BY `forumtheme_last_date` DESC
        LIMIT 10";
$forum_sql = f_igosja_mysqli_query($sql);

$forum_array = $forum_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = 'Хоккейный онлайн-менеджер';
$seo_description    = 'Виртуальная Хоккейная Лига - лучший бесплатный хоккейный онлайн-менеджер.';

include(__DIR__ . '/view/layout/main.php');