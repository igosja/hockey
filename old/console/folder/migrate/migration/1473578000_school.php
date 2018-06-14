<?php

$q = array();

$q[] = 'CREATE TABLE `school`
        (
            `school_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `school_day` INT(2) DEFAULT 0,
            `school_position_id` INT(1) DEFAULT 0,
            `school_ready` INT(1) DEFAULT 0,
            `school_season_id` INT(5) DEFAULT 0,
            `school_special_id` INT(2) DEFAULT 0,
            `school_style_id` INT(1) DEFAULT 0,
            `school_team_id` INT(5) DEFAULT 0,
            `school_with_special` INT(1) DEFAULT 0,
            `school_with_style` INT(1) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `school_ready` ON `school` (`school_ready`);';
$q[] = 'CREATE INDEX `school_season_id` ON `school` (`school_season_id`)';
$q[] = 'CREATE INDEX `school_team_id` ON `school` (`school_team_id`);';