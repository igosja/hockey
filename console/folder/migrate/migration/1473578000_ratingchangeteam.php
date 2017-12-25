<?php

$q = array();

$q[] = 'CREATE TABLE `ratingchangeteam`
        (
            `ratingchangeteam_ratintype_id` INT(2) DEFAULT 0,
            `ratingchangeteam_schedule_id` INT(11) DEFAULT 0,
            `ratingchangeteam_team_id` INT(11) DEFAULT 0,
            `ratingchangeteam_value` DECIMAL(14,3) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `ratingchangeteam_team_id` ON `ratingchangeteam` (`ratingchangeteam_team_id`)';
$q[] = 'CREATE INDEX `ratingchangeteam_schedule_id` ON `ratingchangeteam` (`ratingchangeteam_schedule_id`)';