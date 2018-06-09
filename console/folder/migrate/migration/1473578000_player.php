<?php

$q = array();

$q[] = 'CREATE TABLE `player`
        (
            `player_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `player_age` INT(2) DEFAULT 0,
            `player_country_id` INT(3) DEFAULT 0,
            `player_date_noaction` INT(11) DEFAULT 0,
            `player_date_rookie` INT(11) DEFAULT 0,
            `player_game_row` INT(2) DEFAULT -1,
            `player_game_row_old` INT(2) DEFAULT -1,
            `player_injury` INT(1) DEFAULT 0,
            `player_injury_day` INT(1) DEFAULT 0,
            `player_line_id` INT(1) DEFAULT 1,
            `player_mood_id` INT(1) DEFAULT 0, #Метка супера/отдыха в последнем матче для подсчёта усталости
            `player_name_id` INT(11) DEFAULT 0,
            `player_national_id` INT(11) DEFAULT 0,
            `player_national_line_id` INT(1) DEFAULT 1,
            `player_noaction` INT(11) DEFAULT 0,
            `player_nodeal` INT(1) DEFAULT 0,
            `player_order` INT(3) DEFAULT 0,
            `player_phisical_id` INT(2) DEFAULT 0,
            `player_position_id` INT(1) DEFAULT 0,
            `player_power_nominal` INT(3) DEFAULT 0,
            `player_power_nominal_s` INT(3) DEFAULT 0, #Номинальная сила с учетом спец. возможностей для быстрого подсчета vs команды
            `player_power_old` INT(3) DEFAULT 0,
            `player_power_real` INT(3) DEFAULT 0,
            `player_price` INT(11) DEFAULT 0,
            `player_rent_day` INT(3) DEFAULT 0,
            `player_rent_on` INT(1) DEFAULT 0,
            `player_rent_price` INT(11) DEFAULT 0,
            `player_rent_team_id` INT(11) DEFAULT 0,
            `player_rookie` INT(1) DEFAULT 0,
            `player_salary` INT(11) DEFAULT 0,
            `player_school_id` INT(11) DEFAULT 0,
            `player_style_id` INT(1) DEFAULT 0,
            `player_surname_id` INT(11) DEFAULT 0,
            `player_team_id` INT(11) DEFAULT 0,
            `player_tire` INT(3) DEFAULT 0,
            `player_training_ability` INT(1) DEFAULT 0,
            `player_transfer_on` INT(1) DEFAULT 0,
            `player_transfer_price` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `player_age` ON `player` (`player_age`);';
$q[] = 'CREATE INDEX `player_injury` ON `player` (`player_injury`);';
$q[] = 'CREATE INDEX `player_rent_team_id` ON `player` (`player_rent_team_id`);';
$q[] = 'CREATE INDEX `player_team_id` ON `player` (`player_team_id`);';