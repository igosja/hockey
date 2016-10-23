<?php

$q = array();

$q[] = 'CREATE TABLE `log`
        (
            `log_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `log_building_id` INT(11) DEFAULT 0,
            `log_country_id` INT(11) DEFAULT 0,
            `log_date` INT(11) DEFAULT 0,
            `log_game_id` INT(11) DEFAULT 0,
            `log_logtext_id` INT(11) DEFAULT 0,
            `log_national_id` INT(11) DEFAULT 0,
            `log_player_id` INT(11) DEFAULT 0,
            `log_position_id` INT(11) DEFAULT 0,
            `log_season_id` INT(11) DEFAULT 0,
            `log_special_id` INT(11) DEFAULT 0,
            `log_team_id` INT(11) DEFAULT 0,
            `log_team_2_id` INT(11) DEFAULT 0,
            `log_user_id` INT(11) DEFAULT 0,
            `log_value` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `log_player_id` ON `log` (`log_player_id`);';
$q[] = 'CREATE INDEX `log_team_id` ON `log` (`log_team_id`);';
$q[] = 'CREATE INDEX `log_user_id` ON `log` (`log_user_id`);';