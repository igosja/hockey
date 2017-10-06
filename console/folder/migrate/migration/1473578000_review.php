<?php

$q = array();

$q[] = 'CREATE TABLE `review`
        (
            `review_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `review_country_id` INT(3) DEFAULT 0,
            `review_date` INT(11) DEFAULT 0,
            `review_division_id` INT(1) DEFAULT 0,
            `review_season_id` INT(5) DEFAULT 0,
            `review_schedule_id` INT(11) DEFAULT 0,
            `review_stage_id` INT(2) DEFAULT 0,
            `review_title` VARCHAR(255),
            `review_user_id` INT(11) DEFAULT 0
        );';