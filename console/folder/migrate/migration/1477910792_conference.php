<?php

$q = array();

$q[] = 'CREATE TABLE `conference`
        (
            `conference_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `conference_difference` INT(3) DEFAULT 0,
            `conference_game` INT(2) DEFAULT 0,
            `conference_guest` INT(2) DEFAULT 0,
            `conference_home` INT(2) DEFAULT 0,
            `conference_loose` INT(2) DEFAULT 0,
            `conference_loose_bullet` INT(2) DEFAULT 0,
            `conference_loose_over` INT(2) DEFAULT 0,
            `conference_pass` INT(3) DEFAULT 0,
            `conference_place` INT(5) DEFAULT 0,
            `conference_point` INT(2) DEFAULT 0,
            `conference_score` INT(3) DEFAULT 0,
            `conference_season_id` INT(5) DEFAULT 0,
            `conference_team_id` INT(5) DEFAULT 0,
            `conference_win` INT(2) DEFAULT 0,
            `conference_win_bullet` INT(2) DEFAULT 0,
            `conference_win_over` INT(2) DEFAULT 0
        );';