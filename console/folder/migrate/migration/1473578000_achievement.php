<?php

$q = array();

$q[] = 'CREATE TABLE `achievement`
        (
            `achievement_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `achievement_country_id` INT(3) DEFAULT 0,
            `achievement_division_id` INT(5) DEFAULT 0,
            `achievement_is_playoff` INT(1) DEFAULT 0,
            `achievement_national_id` INT(5) DEFAULT 0,
            `achievement_position` INT(2) DEFAULT 0,
            `achievement_season_id` INT(3) DEFAULT 0,
            `achievement_stage_id` INT(2) DEFAULT 0,
            `achievement_team_id` INT(5) DEFAULT 0,
            `achievement_tournamenttype_id` INT(1) DEFAULT 0,
            `achievement_user_id` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `achievement_team_id` ON `achievement` (`achievement_team_id`)';
$q[] = 'CREATE INDEX `achievement_user_id` ON `achievement` (`achievement_user_id`)';