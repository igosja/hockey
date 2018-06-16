<?php

$q = array();

$q[] = 'CREATE TABLE `electionpresidentapplication`
        (
            `electionpresidentapplication_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `electionpresidentapplication_count` INT(11) DEFAULT 0,
            `electionpresidentapplication_date` INT(11) DEFAULT 0,
            `electionpresidentapplication_electionpresident_id` INT(11) DEFAULT 0,
            `electionpresidentapplication_text` TEXT,
            `electionpresidentapplication_user_id` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `electionpresidentapplication_electionpresident_id` ON `electionpresidentapplication` (`electionpresidentapplication_electionpresident_id`);';