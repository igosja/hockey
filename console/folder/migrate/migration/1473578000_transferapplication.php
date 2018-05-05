<?php

$q = array();

$q[] = 'CREATE TABLE `transferapplication`
        (
            `transferapplication_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `transferapplication_date` INT(11) DEFAULT 0,
            `transferapplication_only_one` INT(1) DEFAULT 0,
            `transferapplication_price` INT(11) DEFAULT 0,
            `transferapplication_team_id` INT(11) DEFAULT 0,
            `transferapplication_transfer_id` INT(11) DEFAULT 0,
            `transferapplication_user_id` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `transferapplication_transfer_id` ON `transferapplication` (`transferapplication_transfer_id`);';