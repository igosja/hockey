<?php

$q = array();

$q[] = 'CREATE TABLE `electionnationalvice`
        (
            `electionnationalvice_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `electionnationalvice_country_id` INT(3) DEFAULT 0,
            `electionnationalvice_date` INT(11) DEFAULT 0,
            `electionnationalvice_electionstatus_id` INT(1) DEFAULT 1,
            `electionnationalvice_nationaltype_id` INT(1) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `electionnationalvice_country_id` ON `electionnationalvice` (`electionnationalvice_country_id`);';
$q[] = 'CREATE INDEX `electionnationalvice_electionstatus_id` ON `electionnationalvice` (`electionnationalvice_electionstatus_id`);';