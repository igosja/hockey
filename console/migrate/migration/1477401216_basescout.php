<?php

$q = array();

$q[] = 'CREATE TABLE `basescout`
        (
            `basescout_id` TINYINT(2) PRIMARY KEY AUTO_INCREMENT,
            `basescout_base_id` TINYINT(2) DEFAULT 0,
            `basescout_build_speed` TINYINT(2) DEFAULT 0,
            `basescout_distance` TINYINT(1) DEFAULT 0,
            `basescout_level` TINYINT(2) DEFAULT 0,
            `basescout_market_game_row` TINYINT(1) DEFAULT 0,
            `basescout_market_phisical` TINYINT(1) DEFAULT 0,
            `basescout_market_tire` TINYINT(1) DEFAULT 0,
            `basescout_my_style_count` TINYINT(2) DEFAULT 0,
            `basescout_my_style_price` INT(11) DEFAULT 0,
            `basescout_opponent_game_row` TINYINT(1) DEFAULT 0,
            `basescout_opponent_phisical` TINYINT(1) DEFAULT 0,
            `basescout_opponent_tire` TINYINT(1) DEFAULT 0,
            `basescout_price_buy` INT(11) DEFAULT 0,
            `basescout_price_sell` INT(11) DEFAULT 0,
            `basescout_scout_speed` TINYINT(1) DEFAULT 0
        );';
$q[] = 'INSERT INTO `basescout`
        (
            `basescout_base_id`,
            `basescout_build_speed`,
            `basescout_distance`,
            `basescout_level`,
            `basescout_market_game_row`,
            `basescout_market_phisical`,
            `basescout_market_tire`,
            `basescout_my_style_count`,
            `basescout_my_style_price`,
            `basescout_opponent_game_row`,
            `basescout_opponent_phisical`,
            `basescout_opponent_tire`,
            `basescout_price_buy`,
            `basescout_price_sell`,
            `basescout_scout_speed`
        )
        VALUES (0,  0, 0,  0, 0, 0, 0,  0,      0, 0, 0, 0,       0,       0,   0),
               (1,  1, 1,  1, 0, 0, 0,  5,  25000, 1, 0, 0,  250000,  187500,  10),
               (1,  2, 1,  2, 0, 0, 0, 10,  50000, 1, 0, 1,  500000,  375000,  20),
               (2,  3, 2,  3, 0, 0, 0, 15,  75000, 1, 1, 1,  750000,  562500,  30),
               (2,  4, 2,  4, 1, 0, 0, 20, 100000, 1, 1, 1, 1000000,  750000,  40),
               (3,  5, 3,  5, 1, 0, 1, 25, 125000, 1, 1, 1, 1250000,  937500,  50),
               (3,  6, 3,  6, 1, 1, 1, 30, 150000, 1, 1, 1, 1500000, 1125000,  60),
               (4,  7, 4,  7, 1, 1, 1, 35, 175000, 1, 1, 1, 1750000, 1312500,  70),
               (4,  8, 4,  8, 1, 1, 1, 40, 200000, 1, 1, 1, 2000000, 1500000,  80),
               (5,  9, 5,  9, 1, 1, 1, 45, 225000, 1, 1, 1, 2250000, 1687500,  90),
               (5, 10, 5, 10, 1, 1, 1, 50, 250000, 1, 1, 1, 2500000, 1875000, 100);';