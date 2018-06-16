<?php

/**
 * Зміна статусу голосувань за тренерів сбірних
 */
function f_igosja_generator_national_vote_status()
{
    $sql = "SELECT `electionnational_id`
            FROM `electionnational`
            LEFT JOIN
            (
                SELECT COUNT(`electionnationalapplication_id`) AS `count`,
                       `electionnationalapplication_electionnational_id`
                FROM `electionnationalapplication`
                GROUP BY `electionnationalapplication_electionnational_id`
            ) AS `t1`
            ON `electionnational_id`=`electionnationalapplication_electionnational_id`
            WHERE `electionnational_electionstatus_id`=" . ELECTIONSTATUS_CANDIDATES . "
            AND `electionnational_date`<UNIX_TIMESTAMP()-172800
            AND `count`>0";
    $electionnational_sql = f_igosja_mysqli_query($sql);

    $electionnational_array = $electionnational_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($electionnational_array as $item)
    {
        f_igosja_election_national_to_open($item['electionnational_id']);
    }

    $sql = "SELECT `electionnational_id`
            FROM `electionnational`
            WHERE `electionnational_electionstatus_id`=" . ELECTIONSTATUS_OPEN . "
            AND `electionnational_date`<UNIX_TIMESTAMP()-432000";
    $electionnational_sql = f_igosja_mysqli_query($sql);

    $electionnational_array = $electionnational_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($electionnational_array as $item)
    {
        f_igosja_election_national_to_close($item['electionnational_id']);
    }
}