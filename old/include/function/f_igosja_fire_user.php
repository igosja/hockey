<?php

/**
 * Звільняємо менеджера з посади тренера клубу
 * @param $user_id integer id менеджера
 * @param $team_id integer id команди
 */
function f_igosja_fire_user($user_id, $team_id)
{
    $sql = "UPDATE `team`
            SET `team_auto`=0,
                `team_user_id`=0,
                `team_vice_id`=0,
                `team_vote_national`=" . VOTERATING_NEUTRAL . ",
                `team_vote_president`=" . VOTERATING_NEUTRAL . ",
                `team_vote_u19`=" . VOTERATING_NEUTRAL . ",
                `team_vote_u21`=" . VOTERATING_NEUTRAL . "
            WHERE `team_id`=$team_id
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    $sql = "DELETE FROM `transferapplication`
            WHERE `transferapplication_team_id`=$team_id
            AND `transferapplication_transfer_id` IN
            (
                SELECT `transfer_id`
                FROM `transfer`
                WHERE `transfer_ready`=0
            )";
    f_igosja_mysqli_query($sql);

    $sql = "DELETE FROM `transferapplication`
            WHERE `transferapplication_transfer_id` IN
            (
                SELECT `transfer_id`
                FROM `transfer`
                WHERE `transfer_team_seller_id`=$team_id
                AND `transfer_ready`=0
            )";
    f_igosja_mysqli_query($sql);

    $sql = "DELETE FROM `transfer`
            WHERE `transfer_team_seller_id`=$team_id
            AND `transfer_ready`=0";
    f_igosja_mysqli_query($sql);

    $sql = "DELETE FROM `rentapplication`
            WHERE `rentapplication_team_id`=$team_id
            AND `rentapplication_rent_id` IN
            (
                SELECT `rent_id`
                FROM `rent`
                WHERE `rent_ready`=0
            )";
    f_igosja_mysqli_query($sql);

    $sql = "DELETE FROM `rentapplication`
            WHERE `rentapplication_rent_id` IN
            (
                SELECT `rent_id`
                FROM `rent`
                WHERE `rent_team_seller_id`=$team_id
                AND `rent_ready`=0
            )";
    f_igosja_mysqli_query($sql);

    $sql = "DELETE FROM `rent`
            WHERE `rent_team_seller_id`=$team_id
            AND `rent_ready`=0";
    f_igosja_mysqli_query($sql);

    $log = array(
        'history_historytext_id' => HISTORYTEXT_USER_MANAGER_TEAM_OUT,
        'history_team_id' => $team_id,
        'history_user_id' => $user_id,
    );
    f_igosja_history($log);
}