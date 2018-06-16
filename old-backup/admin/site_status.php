<?php

/**
 * @var $site_array array
 */

include(__DIR__ . '/../include/include.php');

$sql = "UPDATE `site`
        SET `site_status`=1-`site_status`
        WHERE `site_id`=1
        LIMIT 1";
f_igosja_mysqli_query($sql);

redirect('/admin/');