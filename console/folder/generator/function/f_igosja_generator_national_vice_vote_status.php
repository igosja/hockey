<?php

/**
 * Зміна статусу голосувань за заступників тренерів сбірних
 */
function f_igosja_generator_national_vice_vote_status()
{
    $sql = "SELECT `electionnationalvice_id`
            FROM `electionnationalvice`
            WHERE `electionnationalvice_electionstatus_id`=" . ELECTIONSTATUS_CANDIDATES . "
            AND `electionnationalvice_date`>UNIX_TIMESTAMP()-172800";
    $electionnationalvice_sql = f_igosja_mysqli_query($sql, false);

    $electionnationalvice_array = $electionnationalvice_sql->fetch_all(1);

    foreach ($electionnationalvice_array as $item)
    {
        f_igosja_election_national_vice_to_open($item['electionnationalvice_id']);
    }

    $sql = "SELECT `electionnationalvice_id`
            FROM `electionnationalvice`
            WHERE `electionnationalvice_electionstatus_id`=" . ELECTIONSTATUS_OPEN . "
            AND `electionnationalvice_date`>UNIX_TIMESTAMP()-432000";
    $electionnationalvice_sql = f_igosja_mysqli_query($sql, false);

    $electionnationalvice_array = $electionnationalvice_sql->fetch_all(1);

    foreach ($electionnationalvice_array as $item)
    {
        f_igosja_election_national_vice_to_close($item['electionnationalvice_id']);
    }
}