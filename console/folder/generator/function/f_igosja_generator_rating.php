<?php

/**
 * Оновлення позицій в рейтингах
 */
function f_igosja_generator_rating()
{
    global $igosja_season_id;

    $sql = "TRUNCATE `ratingcountry`;";
    f_igosja_mysqli_query($sql);


    $sql = "TRUNCATE `ratingteam`;";
    f_igosja_mysqli_query($sql);


    $sql = "TRUNCATE `ratinguser`;";
    f_igosja_mysqli_query($sql);

    $sql = "INSERT INTO `ratingcountry` (`ratingcountry_country_id`)
            SELECT `country_id`
            FROM `team`
            LEFT JOIN `stadium`
            ON `team_stadium_id`=`stadium_id`
            LEFT JOIN `city`
            ON `stadium_city_id`=`city_id`
            LEFT JOIN `country`
            ON `city_country_id`=`country_id`
            WHERE `team_id`!=0
            GROUP BY `country_id`
            ORDER BY `country_id` ASC";
    f_igosja_mysqli_query($sql);

    $sql = "INSERT INTO `ratingteam` (`ratingteam_team_id`)
            SELECT `team_id`
            FROM `team`
            WHERE `team_id`!=0
            ORDER BY `team_id` ASC";
    f_igosja_mysqli_query($sql);

    $sql = "INSERT INTO `ratinguser` (`ratinguser_user_id`)
            SELECT `user_id`
            FROM `user`
            LEFT JOIN `team`
            ON `user_id`=`team_user_id`
            WHERE `team_id` IS NOT NULL
            AND `user_id`!=0
            GROUP BY `user_id`
            ORDER BY `user_id` ASC";
    f_igosja_mysqli_query($sql);

    $sql = "SELECT `ratingtype_id`
            FROM `ratingtype`
            LEFT JOIN `ratingchapter`
            ON `ratingtype_ratingchapter_id`=`ratingchapter_id`
            ORDER BY `ratingchapter_id` ASC, `ratingtype_id` ASC";
    $ratingtype_sql = f_igosja_mysqli_query($sql);

    $ratingtype_array = $ratingtype_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($ratingtype_array as $item)
    {
        if (RATING_TEAM_POWER == $item['ratingtype_id'])
        {
            $order = '`team_power_vs` DESC';
            $place = 'ratingteam_power_vs_place';
        }
        elseif (RATING_TEAM_AGE == $item['ratingtype_id'])
        {
            $order = '`team_age`';
            $place = 'ratingteam_age_place';
        }
        elseif (RATING_TEAM_STADIUM == $item['ratingtype_id'])
        {
            $order = '`team_price_stadium` DESC';
            $place = 'ratingteam_stadium_place';
        }
        elseif (RATING_TEAM_VISITOR == $item['ratingtype_id'])
        {
            $order = '`team_visitor` DESC';
            $place = 'ratingteam_visitor_place';
        }
        elseif (RATING_TEAM_BASE == $item['ratingtype_id'])
        {
            $order = '`team_base_id`+`team_basemedical_id`+`team_basephisical_id`+`team_baseschool_id`+`team_basescout_id`+`team_basetraining_id` DESC';
            $place = 'ratingteam_base_place';
        }
        elseif (RATING_TEAM_PRICE_BASE == $item['ratingtype_id'])
        {
            $order = '`team_price_base` DESC';
            $place = 'ratingteam_price_base_place';
        }
        elseif (RATING_TEAM_PRICE_STADIUM == $item['ratingtype_id'])
        {
            $order = '`team_price_stadium` DESC';
            $place = 'ratingteam_price_stadium_place';
        }
        elseif (RATING_TEAM_PLAYER == $item['ratingtype_id'])
        {
            $order = '`team_player` DESC';
            $place = 'ratingteam_player_place';
        }
        elseif (RATING_TEAM_PRICE_TOTAL == $item['ratingtype_id'])
        {
            $order = '`team_price_total` DESC';
            $place = 'ratingteam_price_total_place';
        }
        elseif (RATING_USER_RATING == $item['ratingtype_id'])
        {
            $order = '`user_rating` DESC';
            $place = 'ratinguser_rating_place';
        }
        elseif (RATING_COUNTRY_STADIUM == $item['ratingtype_id'])
        {
            $order = '`country_stadium` DESC';
            $place = 'ratingcountry_stadium_place';
        }
        elseif (RATING_COUNTRY_AUTO == $item['ratingtype_id'])
        {
            $order = '`country_auto`/`country_game`';
            $place = 'ratingcountry_auto_place';
        }
        elseif (RATING_COUNTRY_LEAGUE == $item['ratingtype_id'])
        {
            $place = 'ratingcountry_league_place';
        }

        if (in_array($item['ratingtype_id'], array(
            RATING_TEAM_AGE,
            RATING_TEAM_BASE,
            RATING_TEAM_PLAYER,
            RATING_TEAM_POWER,
            RATING_TEAM_PRICE_BASE,
            RATING_TEAM_PRICE_STADIUM,
            RATING_TEAM_PRICE_TOTAL,
            RATING_TEAM_STADIUM,
            RATING_TEAM_VISITOR,
        )))
        {
            $sql = "SELECT `team_id`
                    FROM `team`
                    WHERE `team_id`!=0
                    ORDER BY $order, `team_id` ASC";
            $team_sql = f_igosja_mysqli_query($sql);

            $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

            for ($i=0, $count_team=count($team_array); $i<$count_team; $i++)
            {
                $position   = $i + 1;
                $team_id    = $team_array[$i]['team_id'];

                $sql = "UPDATE `ratingteam`
                        SET `$place`=$position
                        WHERE `ratingteam_team_id`=$team_id
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }

            $sql = "SELECT `country_id`
                    FROM `team`
                    LEFT JOIN `stadium`
                    ON `team_stadium_id`=`stadium_id`
                    LEFT JOIN `city`
                    ON `stadium_city_id`=`city_id`
                    LEFT JOIN `country`
                    ON `city_country_id`=`country_id`
                    WHERE `team_id`!=0
                    GROUP BY `country_id`
                    ORDER BY `country_id` ASC";
            $country_sql = f_igosja_mysqli_query($sql);

            $country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

            foreach ($country_array as $country)
            {
                $country_id = $country['country_id'];

                $sql = "SELECT `team_id`
                        FROM `team`
                        LEFT JOIN `stadium`
                        ON `team_stadium_id`=`stadium_id`
                        LEFT JOIN `city`
                        ON `stadium_city_id`=`city_id`
                        WHERE `city_country_id`=$country_id
                        ORDER BY $order, `team_id` ASC";
                $team_sql = f_igosja_mysqli_query($sql);

                $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

                for ($i=0, $count_team=count($team_array); $i<$count_team; $i++)
                {
                    $place_c    = $place . '_country';
                    $position   = $i + 1;
                    $team_id    = $team_array[$i]['team_id'];

                    $sql = "UPDATE `ratingteam`
                            SET `$place_c`=$position
                            WHERE `ratingteam_team_id`=$team_id
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }
            }
        }
        elseif (RATING_USER_RATING == $item['ratingtype_id'])
        {
            $sql = "SELECT `user_id`
                    FROM `user`
                    LEFT JOIN `team`
                    ON `user_id`=`team_user_id`
                    WHERE `team_id` IS NOT NULL
                    AND `user_id`!=0
                    GROUP BY `user_id`
                    ORDER BY $order, `user_id` ASC";
            $user_sql = f_igosja_mysqli_query($sql);

            $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

            for ($i=0, $count_user=count($user_array); $i<$count_user; $i++)
            {
                $position   = $i + 1;
                $user_id    = $user_array[$i]['user_id'];

                $sql = "UPDATE `ratinguser`
                        SET `$place`=$position
                        WHERE `ratinguser_user_id`=$user_id
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }

            $sql = "SELECT `country_id`
                    FROM `team`
                    LEFT JOIN `stadium`
                    ON `team_stadium_id`=`stadium_id`
                    LEFT JOIN `city`
                    ON `stadium_city_id`=`city_id`
                    LEFT JOIN `country`
                    ON `city_country_id`=`country_id`
                    WHERE `team_id`!=0
                    AND `team_user_id`!=0
                    GROUP BY `country_id`
                    ORDER BY `country_id` ASC";
            $country_sql = f_igosja_mysqli_query($sql);

            $country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

            foreach ($country_array as $country)
            {
                $country_id = $country['country_id'];

                $sql = "SELECT `user_id`
                        FROM `user`
                        LEFT JOIN `team`
                        ON `user_id`=`team_user_id`
                        LEFT JOIN `stadium`
                        ON `team_stadium_id`=`stadium_id`
                        LEFT JOIN `city`
                        ON `stadium_city_id`=`city_id`
                        WHERE `city_country_id`=$country_id
                        AND `user_id`!=0
                        ORDER BY $order, `team_id` ASC";
                $team_sql = f_igosja_mysqli_query($sql);

                $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

                for ($i=0, $count_team=count($team_array); $i<$count_team; $i++)
                {
                    $place_c    = $place . '_country';
                    $position   = $i + 1;
                    $user_id    = $team_array[$i]['user_id'];

                    $sql = "UPDATE `ratinguser`
                            SET `$place_c`=$position
                            WHERE `ratinguser_user_id`=$user_id
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }
            }
        }
        elseif (in_array($item['ratingtype_id'], array(RATING_COUNTRY_AUTO, RATING_COUNTRY_STADIUM)))
        {
            $sql = "SELECT `country_id`
                    FROM `city`
                    LEFT JOIN `country`
                    ON `city_country_id`=`country_id`
                    WHERE `city_id`!=0
                    GROUP BY `country_id`
                    ORDER BY $order, `country_id` ASC";
            $country_sql = f_igosja_mysqli_query($sql);

            $country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

            for ($i=0, $count_country=count($country_array); $i<$count_country; $i++)
            {
                $position   = $i + 1;
                $country_id = $country_array[$i]['country_id'];

                $sql = "UPDATE `ratingcountry`
                        SET `$place`=$position
                        WHERE `ratingcountry_country_id`=$country_id
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }
        }
        elseif (RATING_COUNTRY_LEAGUE == $item['ratingtype_id'])
        {
            $sql = "SELECT `country_id`
                    FROM `city`
                    LEFT JOIN `country`
                    ON `city_country_id`=`country_id`
                    LEFT JOIN 
                    (
                        SELECT SUM(`leaguecoefficient_point`)/COUNT(`leaguecoefficient_team_id`) AS `leaguecoefficient_coeff_1`,
                               `leaguecoefficient_country_id`
                        FROM `leaguecoefficient`
                        WHERE `leaguecoefficient_season_id`=$igosja_season_id
                        GROUP BY `leaguecoefficient_country_id`
                    ) AS `t1`
                    ON `country_id`=`t1`.`leaguecoefficient_country_id`
                    LEFT JOIN 
                    (
                        SELECT SUM(`leaguecoefficient_point`)/COUNT(`leaguecoefficient_team_id`) AS `leaguecoefficient_coeff_2`,
                               `leaguecoefficient_country_id`
                        FROM `leaguecoefficient`
                        WHERE `leaguecoefficient_season_id`=$igosja_season_id-1
                        GROUP BY `leaguecoefficient_country_id`
                    ) AS `t2`
                    ON `country_id`=`t2`.`leaguecoefficient_country_id`
                    LEFT JOIN 
                    (
                        SELECT SUM(`leaguecoefficient_point`)/COUNT(`leaguecoefficient_team_id`) AS `leaguecoefficient_coeff_3`,
                               `leaguecoefficient_country_id`
                        FROM `leaguecoefficient`
                        WHERE `leaguecoefficient_season_id`=$igosja_season_id-2
                        GROUP BY `leaguecoefficient_country_id`
                    ) AS `t3`
                    ON `country_id`=`t3`.`leaguecoefficient_country_id`
                    LEFT JOIN 
                    (
                        SELECT SUM(`leaguecoefficient_point`)/COUNT(`leaguecoefficient_team_id`) AS `leaguecoefficient_coeff_4`,
                               `leaguecoefficient_country_id`
                        FROM `leaguecoefficient`
                        WHERE `leaguecoefficient_season_id`=$igosja_season_id-3
                        GROUP BY `leaguecoefficient_country_id`
                    ) AS `t4`
                    ON `country_id`=`t4`.`leaguecoefficient_country_id`
                    LEFT JOIN 
                    (
                        SELECT SUM(`leaguecoefficient_point`)/COUNT(`leaguecoefficient_team_id`) AS `leaguecoefficient_coeff_5`,
                               `leaguecoefficient_country_id`
                        FROM `leaguecoefficient`
                        WHERE `leaguecoefficient_season_id`=$igosja_season_id-4
                        GROUP BY `leaguecoefficient_country_id`
                    ) AS `t5`
                    ON `country_id`=`t5`.`leaguecoefficient_country_id`
                    WHERE `city_id`!=0
                    GROUP BY `country_id`
                    ORDER BY IFNULL(`leaguecoefficient_coeff_1`, 0)+IFNULL(`leaguecoefficient_coeff_2`, 0)+IFNULL(`leaguecoefficient_coeff_3`, 0)+IFNULL(`leaguecoefficient_coeff_4`, 0)+IFNULL(`leaguecoefficient_coeff_5`, 0) DESC, `country_id` ASC";
            $country_sql = f_igosja_mysqli_query($sql);

            $country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

            for ($i=0, $count_country=count($country_array); $i<$count_country; $i++)
            {
                $position   = $i + 1;
                $country_id = $country_array[$i]['country_id'];

                $sql = "UPDATE `ratingcountry`
                        SET `$place`=$position
                        WHERE `ratingcountry_country_id`=$country_id
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }
        }
    }
}