<?php

$q = array();

$q[] = 'CREATE TABLE `electionpresident`
        (
            `electionpresident_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `electionpresident_country_id` INT(3) DEFAULT 0,
            `electionpresident_date` INT(11) DEFAULT 0,
            `electionpresident_electionstatus_id` INT(1) DEFAULT 1
        );';
$q[] = 'CREATE INDEX `electionpresident_country_id` ON `electionpresident` (`electionpresident_country_id`);';
$q[] = 'CREATE INDEX `electionpresident_electionstatus_id` ON `electionpresident` (`electionpresident_electionstatus_id`);';