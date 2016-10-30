<?php

include (__DIR__ . '/include/include.php');

$sql = "SELECT `rule_id`,
               `rule_title`
        FROM `rule`
        ORDER BY `rule_order` DESC";
$rule_sql = igosja_db_query($sql);

$rule_array = $rule_sql->fetch_all(1);

include (__DIR__ . '/view/layout/main.php');