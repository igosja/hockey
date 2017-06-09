<?php

$q = array();

$q[] = 'CREATE TABLE `player`
        (
            `player_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `player_age` TINYINT(2) DEFAULT 0,
            `player_country_id` SMALLINT(3) DEFAULT 0,
            `player_date_noaction` INT(11) DEFAULT 0,
            `player_date_rookie` INT(11) DEFAULT 0,
            `player_game_row` TINYINT(2) DEFAULT -1,
            `player_game_row_old` TINYINT(2) DEFAULT -1,
            `player_injury` TINYINT(1) DEFAULT 0,
            `player_mood_id` TINYINT(1) DEFAULT 0, #Метка супера/отдыха в последнем матче для подсчёта усталости
            `player_name_id` INT(11) DEFAULT 0,
            `player_noaction` INT(11) DEFAULT 0,
            `player_phisical_id` TINYINT(2) DEFAULT 0,
            `player_power_nominal` SMALLINT(3) DEFAULT 0,
            `player_power_nominal_s` SMALLINT(3) DEFAULT 0, #Номинальная сила с учетом спец. возможностей для быстрого подсчета vs команды
            `player_power_old` SMALLINT(3) DEFAULT 0,
            `player_power_real` SMALLINT(3) DEFAULT 0,
            `player_price` INT(11) DEFAULT 0,
            `player_rent_day` TINYINT(3) DEFAULT 0,
            `player_rent_on` TINYINT(1) DEFAULT 0,
            `player_rent_price` INT(11) DEFAULT 0,
            `player_rent_team_id` INT(11) DEFAULT 0,
            `player_rookie` TINYINT(1) DEFAULT 0,
            `player_salary` INT(11) DEFAULT 0,
            `player_school_id` INT(11) DEFAULT 0,
            `player_style_id` TINYINT(1) DEFAULT 0,
            `player_surname_id` INT(11) DEFAULT 0,
            `player_team_id` INT(11) DEFAULT 0,
            `player_tire` TINYINT(3) DEFAULT 0,
            `player_training_ability` TINYINT(1) DEFAULT 0,
            `player_transfer_on` TINYINT(1) DEFAULT 0,
            `player_transfer_price` INT(11) DEFAULT 0
        );';