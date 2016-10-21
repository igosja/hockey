<?php

$q = array();

$q[] = 'CREATE TABLE `season`
        (
            `season_id` INT(11) PRIMARY KEY AUTO_INCREMENT
        );';
$q[] = 'INSERT INTO `season`
        SET `season_id`=NULL';