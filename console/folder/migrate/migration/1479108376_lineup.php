<?php

$q = array();

$q[] = 'CREATE TABLE `lineup`
        (
            `lineup_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `lineup_age` TINYINT(2) DEFAULT 0,
            `lineup_assist` TINYINT(3) DEFAULT 0,
            `lineup_game_id` INT(1) DEFAULT 0,
            `lineup_line_id` TINYINT(1) DEFAULT 0,
            `lineup_national_id` SMALLINT(5) DEFAULT 0,
            `lineup_pass` TINYINT(3) DEFAULT 0,
            `lineup_penalty` TINYINT(3) DEFAULT 0,
            `lineup_player_id` INT(1) DEFAULT 0,
            `lineup_plus_minus` TINYINT(3) DEFAULT 0,
            `lineup_position_id` TINYINT(1) DEFAULT 0,
            `lineup_power_nominal` SMALLINT(3) DEFAULT 0,
            `lineup_power_real` SMALLINT(3) DEFAULT 0,
            `lineup_score` TINYINT(3) DEFAULT 0,
            `lineup_shot` TINYINT(3) DEFAULT 0,
            `lineup_team_id` SMALLINT(5) DEFAULT 0
        );';