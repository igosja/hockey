<?php

/**
 * Звільняємо менеджера з посади тренера клубу
 * @param $user_id integer id менеджера
 * @param $team_id integer id команди
 */
function f_igosja_fire_user($user_id, $team_id)
{
    $sql = "UPDATE `team`
            SET `team_user_id`=0,
                `team_vice_id`=0,
                `team_vote_national`=" . VOTERATING_NEUTRAL . ",
                `team_vote_president`=" . VOTERATING_NEUTRAL . ",
                `team_vote_u19`=" . VOTERATING_NEUTRAL . ",
                `team_vote_u21`=" . VOTERATING_NEUTRAL . "
            WHERE `team_id`=$team_id
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    $log = array(
        'history_historytext_id' => HISTORYTEXT_USER_MANAGER_TEAM_OUT,
        'history_team_id' => $team_id,
        'history_user_id' => $user_id,
    );
    f_igosja_history($log);
}