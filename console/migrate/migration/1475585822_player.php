<?php

$q = array();

$q[] = 'CREATE TABLE `player`
        (
            `player_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `player_age` INT(11) DEFAULT 0,
            `player_country_id` INT(11) DEFAULT 0,
            `player_game_row` INT(11) DEFAULT -1,
            `player_name_id` INT(11) DEFAULT 0,
            `player_power_real` INT(11) DEFAULT 0,
            `player_power_nominal` INT(11) DEFAULT 0,
            `player_power_old` INT(11) DEFAULT 0,
            `player_price` INT(11) DEFAULT 0,
            `player_rent_day` INT(11) DEFAULT 0,
            `player_rent_on` INT(11) DEFAULT 0,
            `player_rent_price` INT(11) DEFAULT 0,
            `player_rent_team_id` INT(11) DEFAULT 0,
            `player_salary` INT(11) DEFAULT 0,
            `player_school_id` INT(11) DEFAULT 0,
            `player_shape` INT(11) DEFAULT 0,
            `player_style_id` INT(11) DEFAULT 0,
            `player_surname_id` INT(11) DEFAULT 0,
            `player_team_id` INT(11) DEFAULT 0,
            `player_tire` INT(11) DEFAULT 0,
            `player_training_ability` INT(11) DEFAULT 0,
            `player_transfer_on` INT(11) DEFAULT 0,
            `player_transfer_price` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `player_country_id` ON `player` (`player_country_id`);';
$q[] = 'CREATE INDEX `player_name_id` ON `player` (`player_name_id`);';
$q[] = 'CREATE INDEX `player_rent_team_id` ON `player` (`player_rent_team_id`);';
$q[] = 'CREATE INDEX `player_school_id` ON `player` (`player_school_id`);';
$q[] = 'CREATE INDEX `player_style_id` ON `player` (`player_style_id`);';
$q[] = 'CREATE INDEX `player_surname_id` ON `player` (`player_surname_id`);';
$q[] = 'CREATE INDEX `player_team_id` ON `player` (`player_team_id`);';