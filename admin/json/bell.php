<?php

include(__DIR__ . '/../../include/include.php');

$sql = "SELECT COUNT(`teamask_id`) AS `count`
        FROM `teamask`";
$teamask_sql = f_igosja_mysqli_query($sql);

$teamask_array = $teamask_sql->fetch_all(MYSQLI_ASSOC);

$teamask = $teamask_array[0]['count'];

$sql = "SELECT COUNT(`message_id`) AS `count`
        FROM `message`
        WHERE `message_support_to`=1
        AND `message_read`=0";
$support_sql = f_igosja_mysqli_query($sql);

$support_array = $support_sql->fetch_all(MYSQLI_ASSOC);

$support = $support_array[0]['count'];

$bell = $teamask + $support;

if (0 == $teamask)
{
    $teamask = '';
}

if (0 == $support)
{
    $support = '';
}

if (0 == $bell)
{
    $bell = '';
}

$return = array('bell' => $bell, 'teamask' => $teamask, 'support' => $support);

print json_encode($return);
exit;