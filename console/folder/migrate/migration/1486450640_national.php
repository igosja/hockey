<?php

$q = array();

$q[] = 'CREATE TABLE `national`
        (
            `national_id` TINYINT(1) PRIMARY KEY AUTO_INCREMENT,
            `national_country_id` SMALLINT(3) DEFAULT 0,
            `national_finance` INT(11) DEFAULT 0,
            `national_nationaltype_id` TINYINT(1) DEFAULT 0,
            `national_power_c_16` SMALLINT(5) DEFAULT 0,
            `national_power_c_21` SMALLINT(5) DEFAULT 0,
            `national_power_c_27` SMALLINT(5) DEFAULT 0,
            `national_power_s_16` SMALLINT(5) DEFAULT 0,
            `national_power_s_21` SMALLINT(5) DEFAULT 0,
            `national_power_s_27` SMALLINT(5) DEFAULT 0,
            `national_power_v` SMALLINT(5) DEFAULT 0,
            `national_power_vs` SMALLINT(5) DEFAULT 0,
            `national_stadium_id` INT(11) DEFAULT 0,
            `national_user_id` INT(11) DEFAULT 0,
            `national_vice_id` INT(11) DEFAULT 0,
            `national_visitor` SMALLINT(3) DEFAULT 100
        );';