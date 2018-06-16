<?php

$q = array();

$q[] = 'CREATE TABLE `history`
        (
            `history_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `history_building_id` INT(1) DEFAULT 0,
            `history_country_id` INT(3) DEFAULT 0,
            `history_date` INT(11) DEFAULT 0,
            `history_game_id` INT(11) DEFAULT 0,
            `history_historytext_id` INT(2) DEFAULT 0,
            `history_national_id` INT(3) DEFAULT 0,
            `history_player_id` INT(11) DEFAULT 0,
            `history_position_id` INT(1) DEFAULT 0,
            `history_season_id` INT(5) DEFAULT 0,
            `history_special_id` INT(2) DEFAULT 0,
            `history_team_id` INT(11) DEFAULT 0,
            `history_team_2_id` INT(11) DEFAULT 0,
            `history_user_id` INT(11) DEFAULT 0,
            `history_user_2_id` INT(11) DEFAULT 0,
            `history_value` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `history_player_id` ON `history` (`history_player_id`);';
$q[] = 'CREATE INDEX `history_team_id` ON `history` (`history_team_id`);';
$q[] = 'CREATE INDEX `history_user_id` ON `history` (`history_user_id`);';