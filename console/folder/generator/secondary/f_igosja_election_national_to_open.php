<?php

/**
 * Переводимо голосування за тренера збірної зі статуса збір кандидатур в статус відкрито
 * @param $nationaltype_id integer id типу збірної
 * @param $country_id integer id країни
 */
function f_igosja_election_national_to_open($nationaltype_id, $country_id = 0)
{
    if ($country_id)
    {
        $sql = "UPDATE `electionnational`
                SET `electionnational_electionstatus_id`=" . ELECTIONSTATUS_OPEN . "
                WHERE `electionnational_electionstatus_id`=" . ELECTIONSTATUS_CANDIDATES . "
                AND `electionnational_nationaltype_id`=$nationaltype_id
                AND `electionnational_country_id`=$country_id";
        f_igosja_mysqli_query($sql);
    }
    else
    {
        $sql = "UPDATE `electionnational`
                SET `electionnational_electionstatus_id`=" . ELECTIONSTATUS_OPEN . "
                WHERE `electionnational_electionstatus_id`=" . ELECTIONSTATUS_CANDIDATES . "
                AND `electionnational_nationaltype_id`=$nationaltype_id";
        f_igosja_mysqli_query($sql);
    }
}