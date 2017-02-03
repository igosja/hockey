<?php

$q = array();

$q[] = 'CREATE TABLE `rentapplication`
        (
            `rentapplication_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `rentapplication_date` INT(11) DEFAULT 0,
            `rentapplication_day` INT(11) DEFAULT 0,
            `rentapplication_price` INT(11) DEFAULT 0,
            `rentapplication_team_id` INT(11) DEFAULT 0,
            `rentapplication_rent_id` INT(11) DEFAULT 0,
            `rentapplication_user_id` INT(11) DEFAULT 0
        );';