<?php

$q = array();

$q[] = 'CREATE TABLE `electionnationaluser`
        (
            `electionnationaluser_date` INT(11) DEFAULT 0,
            `electionnationaluser_electionnational_id` INT(11) DEFAULT 0,
            `electionnationaluser_electionnationalapplication_id` INT(11) DEFAULT 0,
            `electionnationaluser_user_id` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `electionnationaluser_electionnationalapplication_id` ON `electionnationaluser` (`electionnationaluser_electionnationalapplication_id`);';