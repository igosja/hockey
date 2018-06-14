<?php

$q = array();

$q[] = 'CREATE TABLE `national`
        (
            `national_id` INT(1) PRIMARY KEY AUTO_INCREMENT,
            `national_country_id` INT(3) DEFAULT 0,
            `national_finance` INT(11) DEFAULT 0,
            `national_mood_rest` INT(1) DEFAULT 2,
            `national_mood_super` INT(1) DEFAULT 2,
            `national_nationaltype_id` INT(1) DEFAULT 0,
            `national_power_c_16` INT(5) DEFAULT 0,
            `national_power_c_21` INT(5) DEFAULT 0,
            `national_power_c_27` INT(5) DEFAULT 0,
            `national_power_s_16` INT(5) DEFAULT 0,
            `national_power_s_21` INT(5) DEFAULT 0,
            `national_power_s_27` INT(5) DEFAULT 0,
            `national_power_v` INT(5) DEFAULT 0,
            `national_power_vs` INT(5) DEFAULT 0,
            `national_stadium_id` INT(11) DEFAULT 0,
            `national_user_id` INT(11) DEFAULT 0,
            `national_vice_id` INT(11) DEFAULT 0,
            `national_visitor` INT(3) DEFAULT 100
        );';
$q[] = 'CREATE INDEX `national_country_id` ON `national` (`national_country_id`);';
$q[] = 'CREATE INDEX `national_user_id` ON `national` (`national_user_id`);';