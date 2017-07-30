<?php

/**
 * Зміна статусу голосувань за заступників президентів федерацій
 */
function f_igosja_generator_president_vice_vote_status()
{
    $sql = "SELECT `electionpresidentvice_id`
            FROM `electionpresidentvice`
            WHERE `electionpresidentvice_electionstatus_id`=" . ELECTIONSTATUS_CANDIDATES . "
            AND `electionpresidentvice_date`>UNIX_TIMESTAMP()-172800";
    $electionpresidentvice_sql = f_igosja_mysqli_query($sql);

    $electionpresidentvice_array = $electionpresidentvice_sql->fetch_all(1);

    foreach ($electionpresidentvice_array as $item)
    {
        f_igosja_election_president_vice_to_open($item['electionpresidentvice_id']);
    }

    $sql = "SELECT `electionpresidentvice_id`
            FROM `electionpresidentvice`
            WHERE `electionpresidentvice_electionstatus_id`=" . ELECTIONSTATUS_OPEN . "
            AND `electionpresidentvice_date`>UNIX_TIMESTAMP()-432000";
    $electionpresidentvice_sql = f_igosja_mysqli_query($sql);

    $electionpresidentvice_array = $electionpresidentvice_sql->fetch_all(1);

    foreach ($electionpresidentvice_array as $item)
    {
        f_igosja_election_president_vice_to_close($item['electionpresidentvice_id']);
    }
}