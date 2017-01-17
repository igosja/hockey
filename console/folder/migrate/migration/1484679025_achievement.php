<?php

$q = array();

$q[] = 'CREATE TABLE `achievement`
        (
            `achievement_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `achievement_country_id` SMALLINT(3) DEFAULT 0,
            `achievement_division_id` SMALLINT(5) DEFAULT 0,
            `achievement_is_playoff` TINYINT(1) DEFAULT 0,
            `achievement_national_id` SMALLINT(5) DEFAULT 0,
            `achievement_position` TINYINT(2) DEFAULT 0,
            `achievement_season_id` TINYINT(3) DEFAULT 0,
            `achievement_stage_id` TINYINT(2) DEFAULT 0,
            `achievement_team_id` SMALLINT(5) DEFAULT 0,
            `achievement_tournamenttype_id` TINYINT(1) DEFAULT 0,
            `achievement_user_id` INT(11) DEFAULT 0
        );';