<?php

$q = array();

$q[] = 'CREATE TABLE `lineup`
        (
            `lineup_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `lineup_age` INT(2) DEFAULT 0,
            `lineup_assist` INT(3) DEFAULT 0,
            `lineup_game_id` INT(1) DEFAULT 0,
            `lineup_line_id` INT(1) DEFAULT 0,
            `lineup_national_id` INT(5) DEFAULT 0,
            `lineup_pass` INT(3) DEFAULT 0,
            `lineup_penalty` INT(3) DEFAULT 0,
            `lineup_player_id` INT(1) DEFAULT 0,
            `lineup_plus_minus` INT(3) DEFAULT 0,
            `lineup_position_id` INT(1) DEFAULT 0,
            `lineup_power_change` INT(1) DEFAULT 0,
            `lineup_power_nominal` INT(3) DEFAULT 0,
            `lineup_power_real` INT(3) DEFAULT 0,
            `lineup_score` INT(3) DEFAULT 0,
            `lineup_shot` INT(3) DEFAULT 0,
            `lineup_team_id` INT(5) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `lineup_game_id` ON `lineup` (`lineup_game_id`);';
$q[] = 'CREATE INDEX `lineup_player_id` ON `lineup` (`lineup_player_id`);';
$q[] = 'CREATE INDEX `lineup_team_id` ON `lineup` (`lineup_team_id`);';