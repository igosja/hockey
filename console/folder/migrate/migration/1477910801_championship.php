<?php

$q = array();

$q[] = 'CREATE TABLE `championship`
        (
            `championship_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `championship_country_id` SMALLINT(3) DEFAULT 0,
            `championship_difference` SMALLINT(3) DEFAULT 0,
            `championship_division_id` TINYINT(1) DEFAULT 0,
            `championship_game` TINYINT(2) DEFAULT 0,
            `championship_loose` TINYINT(2) DEFAULT 0,
            `championship_loose_bullet` TINYINT(2) DEFAULT 0,
            `championship_loose_over` TINYINT(2) DEFAULT 0,
            `championship_pass` SMALLINT(3) DEFAULT 0,
            `championship_place` TINYINT(2) DEFAULT 0,
            `championship_point` TINYINT(2) DEFAULT 0,
            `championship_score` SMALLINT(3) DEFAULT 0,
            `championship_season_id` SMALLINT(5) DEFAULT 0,
            `championship_team_id` SMALLINT(5) DEFAULT 0,
            `championship_win` TINYINT(2) DEFAULT 0,
            `championship_win_bullet` TINYINT(2) DEFAULT 0,
            `championship_win_over` TINYINT(2) DEFAULT 0
        );';