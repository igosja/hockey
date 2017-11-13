<?php

include(__DIR__ . '/../include/include.php');

$db_host = 'igosja.beget.tech';

$mysqli1 = new mysqli($db_host, $db_user, $db_password, $db_database) or die('No MySQL connection');

$sql = "SELECT `user_code`,
               `user_date_confirm`,
               `user_email`,
               `user_login`,
               `user_password`
        FROM `user`
        WHERE `user_id`>1
        ORDER BY `user_id` ASC";
$user_sql = $mysqli1->query($sql);

$user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

print 'array(';
print '<br/>';

foreach ($user_array as $item)
{
    print 'array(';
    print '<br/>';
    print '\'user_code\' => \'' . $item['user_code'] . '\',';
    print '<br/>';
    if ($item['user_date_confirm'])
    {
        print '\'user_date_confirm\' => time(),';
    }
    else
    {
        print '\'user_date_confirm\' => 0,';
    }
    print '<br/>';
    print '\'user_email\' => \'' . $item['user_email'] . '\',';
    print '<br/>';
    print '\'user_login\' => \'' . $item['user_login'] . '\',';
    print '<br/>';
    print '\'user_password\' => \'' . $item['user_password'] . '\',';
    print '<br/>';
    print '),';
    print '<br/>';
}

print ');';