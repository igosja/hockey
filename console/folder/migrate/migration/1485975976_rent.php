<?php

$q = array();

$q[] = 'CREATE TABLE `rent`
        (
            `rent_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `rent_age` TINYINT(2) DEFAULT 0,
            `rent_date` INT(11) DEFAULT 0,
            `rent_day` TINYINT(2) DEFAULT 0,
            `rent_day_max` TINYINT(2) DEFAULT 0,
            `rent_day_min` TINYINT(2) DEFAULT 0,
            `rent_player_id` INT(11) DEFAULT 0,
            `rent_power` SMALLINT(3) DEFAULT 0,
            `rent_price_buyer` INT(11) DEFAULT 0,
            `rent_price_seller` INT(11) DEFAULT 0,
            `rent_ready` TINYINT(1) DEFAULT 0,
            `rent_team_buyer_id` INT(11) DEFAULT 0,
            `rent_team_seller_id` INT(11) DEFAULT 0,
            `rent_user_buyer_id` INT(11) DEFAULT 0,
            `rent_user_seller_id` INT(11) DEFAULT 0
        );';