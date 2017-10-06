<?php

/**
 * Переводимо голосування за президента федерації зі статуса збір кандидатур в статус відкрито
 * @param $electionpresident_id integer id голосування
 */
function f_igosja_election_president_to_open($electionpresident_id)
{
    $sql = "UPDATE `electionpresident`
            SET `electionpresident_electionstatus_id`=" . ELECTIONSTATUS_OPEN . "
            WHERE `electionpresident_electionstatus_id`=" . ELECTIONSTATUS_CANDIDATES . "
            AND `electionpresident_id`=$electionpresident_id
            LIMIT 1";
    f_igosja_mysqli_query($sql, false);
}