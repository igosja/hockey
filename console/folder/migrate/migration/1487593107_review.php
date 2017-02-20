<?php

$q = array();

$q[] = 'CREATE TABLE `review`
        (
            `review_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `review_country_id` SMALLINT(3) DEFAULT 0,
            `review_date` INT(11) DEFAULT 0,
            `review_division_id` TINYINT(1) DEFAULT 0,
            `review_season_id` SMALLINT(5) DEFAULT 0,
            `review_shedule_id` INT(11) DEFAULT 0,
            `review_stage_id` TINYINT(2) DEFAULT 0,
            `review_title` VARCHAR(255) NOT NULL,
            `review_user_id` INT(11) DEFAULT 0
        );';