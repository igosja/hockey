<?php

$q = array();

$q[] = 'CREATE TABLE `finance`
        (
            `finance_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `finance_building_id` INT(1) DEFAULT 0,
            `finance_capacity` INT(5) DEFAULT 0,
            `finance_comment` TEXT,
            `finance_country_id` INT(3) DEFAULT 0,
            `finance_date` INT(11) DEFAULT 0,
            `finance_financetext_id` INT(2) DEFAULT 0,
            `finance_level` INT(1) DEFAULT 0,
            `finance_national_id` INT(3) DEFAULT 0,
            `finance_player_id` INT(11) DEFAULT 0,
            `finance_season_id` INT(5) DEFAULT 0,
            `finance_team_id` INT(5) DEFAULT 0,
            `finance_user_id` INT(11) DEFAULT 0,
            `finance_value` INT(11) DEFAULT 0,
            `finance_value_after` INT(11) DEFAULT 0,
            `finance_value_before` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `finance_country_id` ON `finance` (`finance_country_id`);';
$q[] = 'CREATE INDEX `finance_season_id` ON `finance` (`finance_season_id`);';
$q[] = 'CREATE INDEX `finance_user_id` ON `finance` (`finance_user_id`);';