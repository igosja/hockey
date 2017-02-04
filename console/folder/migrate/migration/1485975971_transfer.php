<?php

$q = array();

$q[] = 'CREATE TABLE `transfer`
        (
            `transfer_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `transfer_age` TINYINT(2) DEFAULT 0,
            `transfer_date` INT(11) DEFAULT 0,
            `transfer_player_id` INT(11) DEFAULT 0,
            `transfer_power` SMALLINT(3) DEFAULT 0,
            `transfer_price_buyer` INT(11) DEFAULT 0,
            `transfer_price_seller` INT(11) DEFAULT 0,
            `transfer_ready` TINYINT(1) DEFAULT 0,
            `transfer_season_id` SMALLINT(5) DEFAULT 0,
            `transfer_team_buyer_id` INT(11) DEFAULT 0,
            `transfer_team_seller_id` INT(11) DEFAULT 0,
            `transfer_user_buyer_id` INT(11) DEFAULT 0,
            `transfer_user_seller_id` INT(11) DEFAULT 0
        );';