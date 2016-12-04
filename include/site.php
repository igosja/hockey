<?php

$sql = "SELECT `site_status`,
               `site_version_1`,
               `site_version_2`,
               `site_version_3`,
               `site_version_4`,
               `site_version_date`
        FROM `site`
        WHERE `site_id`='1'";
$site_sql = f_igosja_mysqli_query($sql);

$site_array = $site_sql->fetch_all(1);