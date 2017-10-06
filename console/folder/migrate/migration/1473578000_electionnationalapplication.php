<?php

$q = array();

$q[] = 'CREATE TABLE `electionnationalapplication`
        (
            `electionnationalapplication_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `electionnationalapplication_electionnational_id` INT(11) DEFAULT 0,
            `electionnationalapplication_date` INT(11) DEFAULT 0,
            `electionnationalapplication_text` TEXT,
            `electionnationalapplication_user_id` INT(11) DEFAULT 0
        );';