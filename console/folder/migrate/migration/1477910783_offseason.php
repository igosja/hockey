<?php

$q = array();

$q[] = 'CREATE TABLE `offseason`
        (
            `offseason_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `offseason_game` TINYINT(2) DEFAULT 0,
            `offseason_guest` TINYINT(2) DEFAULT 0,
            `offseason_home` TINYINT(2) DEFAULT 0,
            `offseason_loose` TINYINT(2) DEFAULT 0,
            `offseason_loose_over` TINYINT(2) DEFAULT 0,
            `offseason_pass` SMALLINT(3) DEFAULT 0,
            `offseason_place` SMALLINT(5) DEFAULT 0,
            `offseason_point` TINYINT(2) DEFAULT 0,
            `offseason_score` SMALLINT(3) DEFAULT 0,
            `offseason_season_id` SMALLINT(5) DEFAULT 0,
            `offseason_team_id` SMALLINT(5) DEFAULT 0,
            `offseason_win` TINYINT(2) DEFAULT 0,
            `offseason_win_over` TINYINT(2) DEFAULT 0
        );';