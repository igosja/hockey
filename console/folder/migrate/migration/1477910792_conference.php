<?php

$q = array();

$q[] = 'CREATE TABLE `conference`
        (
            `conference_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `conference_difference` SMALLINT(3) DEFAULT 0,
            `conference_game` TINYINT(2) DEFAULT 0,
            `conference_guest` TINYINT(2) DEFAULT 0,
            `conference_home` TINYINT(2) DEFAULT 0,
            `conference_loose` TINYINT(2) DEFAULT 0,
            `conference_loose_bullet` TINYINT(2) DEFAULT 0,
            `conference_loose_over` TINYINT(2) DEFAULT 0,
            `conference_pass` SMALLINT(3) DEFAULT 0,
            `conference_place` SMALLINT(5) DEFAULT 0,
            `conference_point` TINYINT(2) DEFAULT 0,
            `conference_score` SMALLINT(3) DEFAULT 0,
            `conference_season_id` SMALLINT(5) DEFAULT 0,
            `conference_team_id` SMALLINT(5) DEFAULT 0,
            `conference_win` TINYINT(2) DEFAULT 0,
            `conference_win_bullet` TINYINT(2) DEFAULT 0,
            `conference_win_over` TINYINT(2) DEFAULT 0
        );';