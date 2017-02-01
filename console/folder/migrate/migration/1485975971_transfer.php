<?php

$q = array();

$q[] = 'CREATE TABLE `transfer`
        (
            `transfer_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `transfer_age` TINYINT(2) DEFAULT 0,
            `transfer_buyer_id` INT(11) DEFAULT 0,
            `transfer_date` INT(11) DEFAULT 0,
            `transfer_player_id` INT(11) DEFAULT 0,
            `transfer_position_id_1` TINYINT(1) DEFAULT 0,
            `transfer_position_id_2` TINYINT(1) DEFAULT 0,
            `transfer_power` SMALLINT(3) DEFAULT 0,
            `transfer_price` INT(11) DEFAULT 0,
            `transfer_ready` TINYINT(1) DEFAULT 0,
            `transfer_seller_id` INT(11) DEFAULT 0,
            `transfer_special_id_1` TINYINT(2) DEFAULT 0,
            `transfer_special_level_1` TINYINT(1) DEFAULT 0,
            `transfer_special_id_2` TINYINT(2) DEFAULT 0,
            `transfer_special_level_2` TINYINT(1) DEFAULT 0,
            `transfer_special_id_3` TINYINT(2) DEFAULT 0,
            `transfer_special_level_3` TINYINT(1) DEFAULT 0,
            `transfer_special_id_4` TINYINT(2) DEFAULT 0,
            `transfer_special_level_4` TINYINT(1) DEFAULT 0
        );';