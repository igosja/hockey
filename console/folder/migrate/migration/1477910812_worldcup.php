<?php

$q = array();

$q[] = 'CREATE TABLE `worldcup`
        (
            `worldcup_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `worldcup_difference` SMALLINT(3) DEFAULT 0,
            `worldcup_division_id` TINYINT(1) DEFAULT 0,
            `worldcup_game` TINYINT(2) DEFAULT 0,
            `worldcup_loose` TINYINT(2) DEFAULT 0,
            `worldcup_loose_bullet` TINYINT(2) DEFAULT 0,
            `worldcup_loose_over` TINYINT(2) DEFAULT 0,
            `worldcup_national_id` SMALLINT(3) DEFAULT 0,
            `worldcup_pass` SMALLINT(3) DEFAULT 0,
            `worldcup_place` TINYINT(2) DEFAULT 0,
            `worldcup_point` TINYINT(2) DEFAULT 0,
            `worldcup_score` SMALLINT(3) DEFAULT 0,
            `worldcup_season_id` SMALLINT(5) DEFAULT 0,
            `worldcup_win` TINYINT(2) DEFAULT 0,
            `worldcup_win_bullet` TINYINT(2) DEFAULT 0,
            `worldcup_win_over` TINYINT(2) DEFAULT 0
        );';