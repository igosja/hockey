<?php

$q = array();

$q[] = 'CREATE TABLE `electionpresidentuser`
        (
            `electionpresidentuser_date` INT(11) DEFAULT 0,
            `electionpresidentuser_electionpresident_id` INT(11) DEFAULT 0,
            `electionpresidentuser_electionpresidentapplication_id` INT(11) DEFAULT 0,
            `electionpresidentuser_user_id` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `electionpresidentuser_electionpresident_id` ON `electionpresidentuser` (`electionpresidentuser_electionpresident_id`);';
$q[] = 'CREATE INDEX `electionpresidentuser_electionpresidentapplication_id` ON `electionpresidentuser` (`electionpresidentuser_electionpresidentapplication_id`);';