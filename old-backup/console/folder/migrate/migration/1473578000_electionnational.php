<?php

$q = array();

$q[] = 'CREATE TABLE `electionnational`
        (
            `electionnational_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `electionnational_country_id` INT(3) DEFAULT 0,
            `electionnational_date` INT(11) DEFAULT 0,
            `electionnational_electionstatus_id` INT(1) DEFAULT 1,
            `electionnational_nationaltype_id` INT(1) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `electionnational_country_id` ON `electionnational` (`electionnational_country_id`);';
$q[] = 'CREATE INDEX `electionnational_electionstatus_id` ON `electionnational` (`electionnational_electionstatus_id`);';