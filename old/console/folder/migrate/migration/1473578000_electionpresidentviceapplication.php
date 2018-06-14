<?php

$q = array();

$q[] = 'CREATE TABLE `electionpresidentviceapplication`
        (
            `electionpresidentviceapplication_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `electionpresidentviceapplication_count` INT(11) DEFAULT 0,
            `electionpresidentviceapplication_date` INT(11) DEFAULT 0,
            `electionpresidentviceapplication_electionpresidentvice_id` INT(11) DEFAULT 0,
            `electionpresidentviceapplication_text` TEXT,
            `electionpresidentviceapplication_user_id` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `electionpresidentviceapplication_electionpresidentvice_id` ON `electionpresidentviceapplication` (`electionpresidentviceapplication_electionpresidentvice_id`);';