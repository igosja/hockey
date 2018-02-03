<?php

$q = array();

$q[] = 'CREATE TABLE `logo`
        (
            `logo_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `logo_date` INT(11) DEFAULT 0,
            `logo_team_id` INT(5) DEFAULT 0,
            `logo_text` TEXT,
            `logo_user_id` INT(11) DEFAULT 0
        );';