<?php

$q = array();

$q[] = 'CREATE TABLE `electionnationalapplication`
        (
            `electionnationalapplication_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `electionnationalapplication_count` INT(11) DEFAULT 0,
            `electionnationalapplication_date` INT(11) DEFAULT 0,
            `electionnationalapplication_electionnational_id` INT(11) DEFAULT 0,
            `electionnationalapplication_text` TEXT,
            `electionnationalapplication_user_id` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `electionnationalapplication_electionnational_id` ON `electionnationalapplication` (`electionnationalapplication_electionnational_id`);';