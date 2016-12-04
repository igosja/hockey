<?php

$q = array();

$q[] = 'CREATE TABLE `finance`
        (
            `finance_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `finance_capacity` SMALLINT(5) DEFAULT 0,
            `finance_country_id` SMALLINT(3) DEFAULT 0,
            `finance_date` INT(11) DEFAULT 0,
            `finance_financetext_id` TINYINT(2) DEFAULT 0,
            `finance_level` TINYINT(1) DEFAULT 0,
            `finance_national_id` SMALLINT(3) DEFAULT 0,
            `finance_player_id` INT(11) DEFAULT 0,
            `finance_season_id` SMALLINT(5) DEFAULT 0,
            `finance_team_id` SMALLINT(5) DEFAULT 0,
            `finance_value` INT(11) DEFAULT 0,
            `finance_value_after` INT(11) DEFAULT 0,
            `finance_value_before` INT(11) DEFAULT 0
        );';