<?php

$q = array();

$q[] = 'CREATE TABLE `national`
        (
            `national_id` TINYINT(1) PRIMARY KEY AUTO_INCREMENT,
            `national_nationaltype_id` VARCHAR(255) NOT NULL,
            `national_country_id` SMALLINT(3) DEFAULT 0,
            `national_user_id` INT(11) DEFAULT 0,
            `national_finance` INT(11) DEFAULT 0
        );';