<?php

$q = array();

$q[] = 'CREATE TABLE `history`
        (
            `history_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `history_building_id` TINYINT(1) DEFAULT 0,
            `history_country_id` SMALLINT(3) DEFAULT 0,
            `history_date` INT(11) DEFAULT 0,
            `history_game_id` INT(11) DEFAULT 0,
            `history_historytext_id` TINYINT(2) DEFAULT 0,
            `history_national_id` SMALLINT(3) DEFAULT 0,
            `history_player_id` INT(11) DEFAULT 0,
            `history_position_id` TINYINT(1) DEFAULT 0,
            `history_season_id` SMALLINT(5) DEFAULT 0,
            `history_special_id` TINYINT(2) DEFAULT 0,
            `history_team_id` INT(11) DEFAULT 0,
            `history_team_2_id` INT(11) DEFAULT 0,
            `history_user_id` INT(11) DEFAULT 0,
            `history_value` INT(11) DEFAULT 0
        );';