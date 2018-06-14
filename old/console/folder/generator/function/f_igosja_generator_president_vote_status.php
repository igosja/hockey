<?php

/**
 * Зміна статусу голосувань за президентів федерацій
 */
function f_igosja_generator_president_vote_status()
{
    $sql = "SELECT `electionpresident_id`
            FROM `electionpresident`
            LEFT JOIN
            (
                SELECT COUNT(`electionpresidentapplication_id`) AS `count`,
                       `electionpresidentapplication_electionpresident_id`
                FROM `electionpresidentapplication`
                GROUP BY `electionpresidentapplication_electionpresident_id`
            ) AS `t1`
            ON `electionpresident_id`=`electionpresidentapplication_electionpresident_id`
            WHERE `electionpresident_electionstatus_id`=" . ELECTIONSTATUS_CANDIDATES . "
            AND `electionpresident_date`<UNIX_TIMESTAMP()-172800
            AND `count`>0";
    $electionpresident_sql = f_igosja_mysqli_query($sql);

    $electionpresident_array = $electionpresident_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($electionpresident_array as $item)
    {
        f_igosja_election_president_to_open($item['electionpresident_id']);
    }

    $sql = "SELECT `electionpresident_id`
            FROM `electionpresident`
            WHERE `electionpresident_electionstatus_id`=" . ELECTIONSTATUS_OPEN . "
            AND `electionpresident_date`<UNIX_TIMESTAMP()-432000";
    $electionpresident_sql = f_igosja_mysqli_query($sql);

    $electionpresident_array = $electionpresident_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($electionpresident_array as $item)
    {
        f_igosja_election_president_to_close($item['electionpresident_id']);
    }
}