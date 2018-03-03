<?php

$q = array();

$q[] = 'CREATE TABLE `teamask`
        (
            `teamask_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `teamask_date` INT(11) DEFAULT 0,
            `teamask_leave_id` INT(11) DEFAULT 0,
            `teamask_team_id` INT(11) DEFAULT 0,
            `teamask_user_id` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `teamask_user_id` ON `teamask` (`teamask_user_id`);';