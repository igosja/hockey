<?php

$q = array();

$q[] = 'CREATE TABLE `electionpresident`
        (
            `electionpresident_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `electionpresident_country_id` SMALLINT(3) DEFAULT 0,
            `electionpresident_date` INT(11) DEFAULT 0,
            `electionpresident_electionstatus_id` TINYINT(1) DEFAULT 1
        );';