<?php

$q = array();

$q[] = 'CREATE TABLE `electionpresidentvice`
        (
            `electionpresidentvice_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `electionpresidentvice_country_id` INT(3) DEFAULT 0,
            `electionpresidentvice_date` INT(11) DEFAULT 0,
            `electionpresidentvice_electionstatus_id` INT(1) DEFAULT 1
        );';