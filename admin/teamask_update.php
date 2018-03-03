<?php

include(__DIR__ . '/../include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `teamask_leave_id`,
               `teamask_team_id`,
               `teamask_user_id`,
               `user_email`
        FROM `teamask`
        LEFT JOIN `user`
        ON `teamask_user_id`=`user_id`
        WHERE `teamask_id`=$num_get
        LIMIT 1";
$teamask_sql = f_igosja_mysqli_query($sql);

if (0 == $teamask_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$teamask_array = $teamask_sql->fetch_all(MYSQLI_ASSOC);

$team_id = $teamask_array[0]['teamask_team_id'];
$user_id = $teamask_array[0]['teamask_user_id'];
$email   = $teamask_array[0]['user_email'];

$sql = "SELECT COUNT(`team_id`) AS `check`
        FROM `team`
        WHERE `team_id`=$team_id
        AND `team_user_id`=0";
$team_sql = f_igosja_mysqli_query($sql);

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

if (!$team_array[0]['check'])
{
    $sql = "DELETE FROM `teamask`
            WHERE `teamask_team_id`=$team_id";
    f_igosja_mysqli_query($sql);

    redirect('/admin/teamask.php');
}

if ($leave_id = $teamask_array[0]['teamask_leave_id'])
{
    f_igosja_fire_user($user_id, $leave_id);
}

$sql = "UPDATE `team`
        SET `team_user_id`=$user_id
        WHERE `team_id`=$team_id
        LIMIT 1";
f_igosja_mysqli_query($sql);

$sql = "DELETE FROM `teamask`
        WHERE `teamask_user_id`=$user_id";
f_igosja_mysqli_query($sql);

$sql = "DELETE FROM `teamask`
        WHERE `teamask_team_id`=$team_id";
f_igosja_mysqli_query($sql);

$log = array(
    'history_historytext_id' => HISTORYTEXT_USER_MANAGER_TEAM_IN,
    'history_team_id' => $team_id,
    'history_user_id' => $user_id,
);
f_igosja_history($log);

$email_text = 'Ваша заявка на управление командой одобрена.';

$mail = new Mail();
$mail->setTo($email);
$mail->setSubject('Получение команды на сайте Виртуальной Хоккейной Лиги');
$mail->setHtml($email_text);
$mail->send();

f_igosja_session_back_flash_set('success', ALERT_SUCCESS);

redirect('/admin/teamask_list.php');