<?php

/**
 * Переводимо голосування за заступника тренера збірної зі статуса збір кандидатур в статус відкрито
 * @param $electionnationalvice_id integer id голосування
 */
function f_igosja_election_national_vice_to_open($electionnationalvice_id)
{
    $sql = "UPDATE `electionnationalvice`
            SET `electionnationalvice_electionstatus_id`=" . ELECTIONSTATUS_OPEN . "
            WHERE `electionnationalvice_electionstatus_id`=" . ELECTIONSTATUS_CANDIDATES . "
            AND `electionnationalvice_id`=$electionnationalvice_id
            LIMIT 1";
    f_igosja_mysqli_query($sql, false);
}