<?php

$q = array();

$q[] = 'CREATE TABLE `vote`
        (
            `vote_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `vote_country_id` INT(3) DEFAULT 0,
            `vote_date` INT(11) DEFAULT 0,
            `vote_text` TEXT NOT NULL,
            `vote_user_id` INT(11) DEFAULT 0,
            `vote_votestatus_id` INT(1) DEFAULT 1
        );';