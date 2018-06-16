<?php

/**
 * Рахуємо рейтинг менеджерів
 */
function f_igosja_generator_user_rating_total()
{
    global $igosja_season_id;

    $sql = "UPDATE `userrating`
            LEFT JOIN
            (
                SELECT SUM(`userrating_auto`) AS `userrating_auto_total`,
                       SUM(`userrating_collision_loose`) AS `userrating_collision_loose_total`,
                       SUM(`userrating_collision_win`) AS `userrating_collision_win_total`,
                       SUM(`userrating_game`) AS `userrating_game_total`,
                       SUM(`userrating_loose`) AS `userrating_loose_total`,
                       SUM(`userrating_loose_equal`) AS `userrating_loose_equal_total`,
                       SUM(`userrating_loose_strong`) AS `userrating_loose_strong_total`,
                       SUM(`userrating_loose_super`) AS `userrating_loose_super_total`,
                       SUM(`userrating_loose_weak`) AS `userrating_loose_weak_total`,
                       SUM(`userrating_looseover`) AS `userrating_looseover_total`,
                       SUM(`userrating_looseover_equal`) AS `userrating_looseover_equal_total`,
                       SUM(`userrating_looseover_strong`) AS `userrating_looseover_strong_total`,
                       SUM(`userrating_looseover_weak`) AS `userrating_looseover_weak_total`,
                       `userrating_user_id` AS `userrating_user_id_total`,
                       SUM(`userrating_vs_super`) AS `userrating_vs_super_total`,
                       SUM(`userrating_vs_rest`) AS `userrating_vs_rest_total`,
                       SUM(`userrating_win`) AS `userrating_win_total`,
                       SUM(`userrating_win_equal`) AS `userrating_win_equal_total`,
                       SUM(`userrating_win_strong`) AS `userrating_win_strong_total`,
                       SUM(`userrating_win_super`) AS `userrating_win_super_total`,
                       SUM(`userrating_win_weak`) AS `userrating_win_weak_total`,
                       SUM(`userrating_winover`) AS `userrating_winover_total`,
                       SUM(`userrating_winover_equal`) AS `userrating_winover_equal_total`,
                       SUM(`userrating_winover_strong`) AS `userrating_winover_strong_total`,
                       SUM(`userrating_winover_weak`) AS `userrating_winover_weak_total`
                FROM `userrating`
                WHERE `userrating_season_id`!=0
                GROUP BY `userrating_user_id`
            ) AS `t1`
            ON `userrating_user_id`=`userrating_user_id_total`
            SET `userrating_auto`=`userrating_auto_total`,
                `userrating_collision_loose`=`userrating_collision_loose_total`,
                `userrating_collision_win`=`userrating_collision_win_total`,
                `userrating_game`=`userrating_game_total`,
                `userrating_loose`=`userrating_loose_total`,
                `userrating_loose_equal`=`userrating_loose_equal_total`,
                `userrating_loose_strong`=`userrating_loose_strong_total`,
                `userrating_loose_super`=`userrating_loose_super_total`,
                `userrating_loose_weak`=`userrating_loose_weak_total`,
                `userrating_looseover`=`userrating_looseover_total`,
                `userrating_looseover_equal`=`userrating_looseover_equal_total`,
                `userrating_looseover_strong`=`userrating_looseover_strong_total`,
                `userrating_looseover_weak`=`userrating_looseover_weak_total`,
                `userrating_vs_super`=`userrating_vs_super_total`,
                `userrating_vs_rest`=`userrating_vs_rest_total`,
                `userrating_win`=`userrating_win_total`,
                `userrating_win_equal`=`userrating_win_equal_total`,
                `userrating_win_strong`=`userrating_win_strong_total`,
                `userrating_win_super`=`userrating_win_super_total`,
                `userrating_win_weak`=`userrating_win_weak_total`,
                `userrating_winover`=`userrating_winover_total`,
                `userrating_winover_equal`=`userrating_winover_equal_total`,
                `userrating_winover_strong`=`userrating_winover_strong_total`,
                `userrating_winover_weak`=`userrating_winover_weak_total`
            WHERE `userrating_season_id`=0";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `userrating`
            SET `userrating_rating`=500
                -`userrating_auto`*0.5
                -`userrating_collision_loose`*3
                +`userrating_collision_win`*3.3
                +`userrating_game`*0.01
                -`userrating_loose_equal`*3
                -`userrating_loose_strong`*1
                -`userrating_loose_super`*5
                -`userrating_loose_weak`*5
                -`userrating_looseover_equal`*1
                -`userrating_looseover_weak`*2
                +`userrating_vs_super`*1.1
                -`userrating_vs_rest`*1
                +`userrating_win_equal`*3.3
                +`userrating_win_strong`*5.5
                +`userrating_win_super`*5.5
                +`userrating_win_weak`*1.1
                +`userrating_winover_equal`*1.1
                +`userrating_winover_strong`*2.2
            WHERE `userrating_season_id`=$igosja_season_id";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `userrating`
            LEFT JOIN
            (
                SELECT `userrating_rating`-500 AS `userrating_rating_100`,
                       `userrating_user_id` AS `userrating_user_id_100`
                FROM `userrating`
                WHERE `userrating_season_id`=$igosja_season_id
                AND `userrating_season_id`!=0
            ) AS `t1`
            ON `userrating_user_id`=`userrating_user_id_100`
            LEFT JOIN
            (
                SELECT ROUND((`userrating_rating`-500)*0.75, 2) AS `userrating_rating_75`,
                       `userrating_user_id` AS `userrating_user_id_75`
                FROM `userrating`
                WHERE `userrating_season_id`=$igosja_season_id-1
                AND `userrating_season_id`!=0
            ) AS `t2`
            ON `userrating_user_id`=`userrating_user_id_75`
            LEFT JOIN
            (
                SELECT ROUND((`userrating_rating`-500)*0.5, 2) AS `userrating_rating_50`,
                       `userrating_user_id` AS `userrating_user_id_50`
                FROM `userrating`
                WHERE `userrating_season_id`=$igosja_season_id-2
                AND `userrating_season_id`!=0
            ) AS `t3`
            ON `userrating_user_id`=`userrating_user_id_50`
            LEFT JOIN
            (
                SELECT ROUND((`userrating_rating`-500)*0.25, 2) AS `userrating_rating_25`,
                       `userrating_user_id` AS `userrating_user_id_25`
                FROM `userrating`
                WHERE `userrating_season_id`=$igosja_season_id-3
                AND `userrating_season_id`!=0
            ) AS `t4`
            ON `userrating_user_id`=`userrating_user_id_25`
            SET `userrating_rating`=500+IFNULL(`userrating_rating_100`, 0)+IFNULL(`userrating_rating_75`, 0)+IFNULL(`userrating_rating_50`, 0)+IFNULL(`userrating_rating_25`, 0)
            WHERE `userrating_season_id`=0";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `user`
            LEFT JOIN `userrating`
            ON `user_id`=`userrating_user_id`
            SET `user_rating`=IFNULL(`userrating_rating`, 500)
            WHERE `user_id`!=0
            AND `userrating_season_id`=0";
    f_igosja_mysqli_query($sql);
}