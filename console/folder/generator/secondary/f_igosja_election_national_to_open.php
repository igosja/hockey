<?php

/**
 * Переводимо голосування за тренера збірної зі статуса збір кандидатур в статус відкрито
 * @param $electionnational_id integer id голосування
 */
function f_igosja_election_national_to_open($electionnational_id)
{
    $sql = "UPDATE `electionnational`
            SET `electionnational_electionstatus_id`=" . ELECTIONSTATUS_OPEN . "
            WHERE `electionnational_electionstatus_id`=" . ELECTIONSTATUS_CANDIDATES . "
            AND `electionnational_id`=$electionnational_id
            LIMIT 1";
    f_igosja_mysqli_query($sql);
}