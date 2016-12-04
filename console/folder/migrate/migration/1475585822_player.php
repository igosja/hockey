<?php

$q = array();

$q[] = 'CREATE TABLE `player`
        (
            `player_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `player_age` TINYINT(2) DEFAULT 0,
            `player_country_id` SMALLINT(3) DEFAULT 0,
            `player_game_row` TINYINT(2) DEFAULT -1,
            `player_name_id` INT(11) DEFAULT 0,
            `player_phisical_id` TINYINT(2) DEFAULT 0,
            `player_power_real` SMALLINT(3) DEFAULT 0,
            `player_power_nominal` SMALLINT(3) DEFAULT 0,
            `player_power_old` SMALLINT(3) DEFAULT 0,
            `player_price` INT(11) DEFAULT 0,
            `player_rent_day` TINYINT(3) DEFAULT 0,
            `player_rent_on` TINYINT(1) DEFAULT 0,
            `player_rent_price` INT(11) DEFAULT 0,
            `player_rent_team_id` INT(11) DEFAULT 0,
            `player_salary` INT(11) DEFAULT 0,
            `player_school_id` INT(11) DEFAULT 0,
            `player_shape` TINYINT(3) DEFAULT 0,
            `player_style_id` TINYINT(1) DEFAULT 0,
            `player_surname_id` INT(11) DEFAULT 0,
            `player_team_id` INT(11) DEFAULT 0,
            `player_tire` TINYINT(3) DEFAULT 0,
            `player_training_ability` TINYINT(1) DEFAULT 0,
            `player_transfer_on` TINYINT(1) DEFAULT 0,
            `player_transfer_price` INT(11) DEFAULT 0
        );';