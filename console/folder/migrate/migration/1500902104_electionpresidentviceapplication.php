<?php

$q = array();

$q[] = 'CREATE TABLE `electionpresidentviceapplication`
        (
            `electionpresidentviceapplication_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `electionpresidentviceapplication_electionpresidentvice_id` INT(11) DEFAULT 0,
            `electionpresidentviceapplication_date` INT(11) DEFAULT 0,
            `electionpresidentviceapplication_text` TEXT NOT NULL,
            `electionpresidentviceapplication_user_id` INT(11) DEFAULT 0
        );';