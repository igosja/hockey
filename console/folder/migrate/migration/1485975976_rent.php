<?php

$q = array();

$q[] = 'CREATE TABLE `rent`
        (
            `rent_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `rent_age` TINYINT(2) DEFAULT 0,
            `rent_buyer_id` INT(11) DEFAULT 0,
            `rent_date` INT(11) DEFAULT 0,
            `rent_day` TINYINT(2) DEFAULT 0,
            `rent_player_id` INT(11) DEFAULT 0,
            `rent_position_id_1` TINYINT(1) DEFAULT 0,
            `rent_position_id_2` TINYINT(1) DEFAULT 0,
            `rent_power` SMALLINT(3) DEFAULT 0,
            `rent_price` INT(11) DEFAULT 0,
            `rent_ready` TINYINT(1) DEFAULT 0,
            `rent_seller_id` INT(11) DEFAULT 0,
            `rent_special_id_1` TINYINT(2) DEFAULT 0,
            `rent_special_level_1` TINYINT(1) DEFAULT 0,
            `rent_special_id_2` TINYINT(2) DEFAULT 0,
            `rent_special_level_2` TINYINT(1) DEFAULT 0,
            `rent_special_id_3` TINYINT(2) DEFAULT 0,
            `rent_special_level_3` TINYINT(1) DEFAULT 0,
            `rent_special_id_4` TINYINT(2) DEFAULT 0,
            `rent_special_level_4` TINYINT(1) DEFAULT 0
        );';