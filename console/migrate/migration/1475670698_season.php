<?php

$q = array();

$q[] = 'CREATE TABLE `season`
        (
            `season_id` SMALLINT(5) PRIMARY KEY AUTO_INCREMENT
        );';
$q[] = 'INSERT INTO `season`
        SET `season_id`=NULL';