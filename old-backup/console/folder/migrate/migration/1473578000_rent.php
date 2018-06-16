<?php

$q = array();

$q[] = 'CREATE TABLE `rent`
        (
            `rent_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `rent_age` INT(2) DEFAULT 0,
            `rent_cancel` INT(1) DEFAULT 0,
            `rent_checked` INT(1) DEFAULT 0,
            `rent_date` INT(11) DEFAULT 0,
            `rent_day` INT(2) DEFAULT 0,
            `rent_day_max` INT(2) DEFAULT 0,
            `rent_day_min` INT(2) DEFAULT 0,
            `rent_player_id` INT(11) DEFAULT 0,
            `rent_player_price` INT(11) DEFAULT 0,
            `rent_power` INT(3) DEFAULT 0,
            `rent_price_buyer` INT(11) DEFAULT 0,
            `rent_price_seller` INT(11) DEFAULT 0,
            `rent_ready` INT(1) DEFAULT 0,
            `rent_season_id` INT(5) DEFAULT 0,
            `rent_team_buyer_id` INT(11) DEFAULT 0,
            `rent_team_seller_id` INT(11) DEFAULT 0,
            `rent_user_buyer_id` INT(11) DEFAULT 0,
            `rent_user_seller_id` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `rent_checked` ON `rent` (`rent_checked`);';
$q[] = 'CREATE INDEX `rent_player_id` ON `rent` (`rent_player_id`);';
$q[] = 'CREATE INDEX `rent_ready` ON `rent` (`rent_ready`);';