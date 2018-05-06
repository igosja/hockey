<?php

/**
 * Переводимо голосування за заступника тренера збірної зі статуса збір кандидатур в статус відкрито
 * @param $electionpresidentvice_id integer id голосування
 */
function f_igosja_election_president_vice_to_open($electionpresidentvice_id)
{
    $sql = "INSERT INTO `electionpresidentviceapplication`
            SET `electionpresidentviceapplication_date`=UNIX_TIMESTAMP(),
                `electionpresidentviceapplication_electionpresidentvice_id`=$electionpresidentvice_id,
                `electionpresidentviceapplication_text`='',
                `electionpresidentviceapplication_user_id`=0";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `electionpresidentvice`
            SET `electionpresidentvice_electionstatus_id`=" . ELECTIONSTATUS_OPEN . "
            WHERE `electionpresidentvice_electionstatus_id`=" . ELECTIONSTATUS_CANDIDATES . "
            AND `electionpresidentvice_id`=$electionpresidentvice_id
            LIMIT 1";
    f_igosja_mysqli_query($sql);
}