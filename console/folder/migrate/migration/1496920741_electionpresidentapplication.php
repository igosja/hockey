<?php

$q = array();

$q[] = 'CREATE TABLE `electionpresidentapplication`
        (
            `electionpresidentapplication_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `electionpresidentapplication_electionpresident_id` INT(11) DEFAULT 0,
            `electionpresidentapplication_date` INT(11) DEFAULT 0,
            `electionpresidentapplication_text` TEXT NOT NULL,
            `electionpresidentapplication_user_id` INT(11) DEFAULT 0
        );';