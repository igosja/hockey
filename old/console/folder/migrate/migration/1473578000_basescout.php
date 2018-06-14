<?php

$q = array();

$q[] = 'CREATE TABLE `basescout`
        (
            `basescout_id` INT(2) PRIMARY KEY AUTO_INCREMENT,
            `basescout_base_level` INT(2) DEFAULT 0,
            `basescout_build_speed` INT(2) DEFAULT 0,
            `basescout_distance` INT(1) DEFAULT 0,
            `basescout_level` INT(2) DEFAULT 0,
            `basescout_market_game_row` INT(1) DEFAULT 0,
            `basescout_market_phisical` INT(1) DEFAULT 0,
            `basescout_market_tire` INT(1) DEFAULT 0,
            `basescout_my_style_count` INT(2) DEFAULT 0,
            `basescout_my_style_price` INT(11) DEFAULT 0,
            `basescout_opponent_game_row` INT(1) DEFAULT 0,
            `basescout_opponent_phisical` INT(1) DEFAULT 0,
            `basescout_opponent_tire` INT(1) DEFAULT 0,
            `basescout_price_buy` INT(11) DEFAULT 0,
            `basescout_price_sell` INT(11) DEFAULT 0,
            `basescout_scout_speed_max` INT(3) DEFAULT 0,
            `basescout_scout_speed_min` INT(3) DEFAULT 0
        );';
$q[] = 'INSERT INTO `basescout`
        (
            `basescout_base_level`,
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
            `basescout_scout_speed_max`,
            `basescout_scout_speed_min`
        )
        VALUES (0,  0, 0,  0, 0, 0, 0,  0,      0, 0, 0, 0,       0,       0,   0,   0),
               (1,  1, 1,  1, 0, 0, 0,  5,  25000, 1, 0, 0,  250000,  187500,  15,   5),
               (1,  2, 1,  2, 0, 0, 0, 10,  50000, 1, 0, 1,  500000,  375000,  25,  15),
               (2,  3, 2,  3, 0, 0, 0, 15,  75000, 1, 1, 1,  750000,  562500,  35,  25),
               (2,  4, 2,  4, 1, 0, 0, 20, 100000, 1, 1, 1, 1000000,  750000,  45,  35),
               (3,  5, 3,  5, 1, 0, 1, 25, 125000, 1, 1, 1, 1250000,  937500,  55,  45),
               (3,  6, 3,  6, 1, 1, 1, 30, 150000, 1, 1, 1, 1500000, 1125000,  65,  55),
               (4,  7, 4,  7, 1, 1, 1, 35, 175000, 1, 1, 1, 1750000, 1312500,  75,  65),
               (4,  8, 4,  8, 1, 1, 1, 40, 200000, 1, 1, 1, 2000000, 1500000,  85,  75),
               (5,  9, 5,  9, 1, 1, 1, 45, 225000, 1, 1, 1, 2250000, 1687500,  95,  85),
               (5, 10, 5, 10, 1, 1, 1, 50, 250000, 1, 1, 1, 2500000, 1875000, 100, 100);';