<?php

$q = array();

$q[] = 'CREATE TABLE `electionnational`
        (
            `electionnational_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `electionnational_country_id` SMALLINT(3) DEFAULT 0,
            `electionnational_date` INT(11) DEFAULT 0,
            `electionnational_electionstatus_id` TINYINT(1) DEFAULT 1,
            `electionnational_nationaltype_id` TINYINT(1) DEFAULT 0
        );';