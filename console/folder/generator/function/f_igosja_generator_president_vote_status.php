<?php

/**
 * Зміна статусу голосувань за президентів федерацій
 */
function f_igosja_generator_president_vote_status()
{
    $sql = "SELECT `electionpresident_id`
            FROM `electionpresident`
            WHERE `electionpresident_electionstatus_id`=" . ELECTIONSTATUS_CANDIDATES . "
            AND `electionpresident_date`>UNIX_TIMESTAMP()-172800";
    $electionpresident_sql = f_igosja_mysqli_query($sql);

    $electionpresident_array = $electionpresident_sql->fetch_all(1);

    foreach ($electionpresident_array as $item)
    {
        f_igosja_election_president_to_open($item['electionpresident_id']);
    }

    $sql = "SELECT `electionpresident_id`
            FROM `electionpresident`
            WHERE `electionpresident_electionstatus_id`=" . ELECTIONSTATUS_OPEN . "
            AND `electionpresident_date`>UNIX_TIMESTAMP()-432000";
    $electionpresident_sql = f_igosja_mysqli_query($sql);

    $electionpresident_array = $electionpresident_sql->fetch_all(1);

    foreach ($electionpresident_array as $item)
    {
        f_igosja_election_president_to_close($item['electionpresident_id']);
    }
}