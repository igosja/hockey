<?php

$q = array();

$q[] = 'CREATE TABLE `transfer`
        (
            `transfer_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `transfer_age` INT(2) DEFAULT 0,
            `transfer_cancel` INT(1) DEFAULT 0,
            `transfer_checked` INT(1) DEFAULT 0,
            `transfer_date` INT(11) DEFAULT 0,
            `transfer_player_id` INT(11) DEFAULT 0,
            `transfer_player_price` INT(11) DEFAULT 0,
            `transfer_power` INT(3) DEFAULT 0,
            `transfer_price_buyer` INT(11) DEFAULT 0,
            `transfer_price_seller` INT(11) DEFAULT 0,
            `transfer_ready` INT(1) DEFAULT 0,
            `transfer_season_id` INT(5) DEFAULT 0,
            `transfer_team_buyer_id` INT(11) DEFAULT 0,
            `transfer_team_seller_id` INT(11) DEFAULT 0,
            `transfer_to_league` INT(1) DEFAULT 0,
            `transfer_user_buyer_id` INT(11) DEFAULT 0,
            `transfer_user_seller_id` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `transfer_checked` ON `transfer` (`transfer_checked`);';
$q[] = 'CREATE INDEX `transfer_player_id` ON `transfer` (`transfer_player_id`);';
$q[] = 'CREATE INDEX `transfer_ready` ON `transfer` (`transfer_ready`);';