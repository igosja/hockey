<?php

$q = array();

$q[] = 'CREATE TABLE `basetraining`
        (
            `basetraining_id` TINYINT(2) PRIMARY KEY AUTO_INCREMENT,
            `basetraining_base_level` TINYINT(2) DEFAULT 0,
            `basetraining_build_speed` TINYINT(2) DEFAULT 0,
            `basetraining_level` TINYINT(2) DEFAULT 0,
            `basetraining_position_count` TINYINT(2) DEFAULT 0,
            `basetraining_position_price` INT(11) DEFAULT 0,
            `basetraining_power_count` TINYINT(2) DEFAULT 0,
            `basetraining_power_price` INT(11) DEFAULT 0,
            `basetraining_price_buy` INT(11) DEFAULT 0,
            `basetraining_price_sell` INT(11) DEFAULT 0,
            `basetraining_special_count` TINYINT(2) DEFAULT 0,
            `basetraining_special_price` INT(11) DEFAULT 0,
            `basetraining_training_speed_max` TINYINT(3) DEFAULT 0,
            `basetraining_training_speed_min` TINYINT(3) DEFAULT 0
        );';
$q[] = 'INSERT INTO `basetraining`
        (
            `basetraining_base_level`,
            `basetraining_build_speed`,
            `basetraining_level`,
            `basetraining_position_count`,
            `basetraining_position_price`,
            `basetraining_power_count`,
            `basetraining_power_price`,
            `basetraining_price_buy`,
            `basetraining_price_sell`,
            `basetraining_special_count`,
            `basetraining_special_price`,
            `basetraining_training_speed_max`,
            `basetraining_training_speed_min`
        )
        VALUES (0,  0,  0, 0,      0,  0,      0,       0,       0, 0,      0,   0,   0),
               (1,  1,  1, 1,  50000,  5,  25000,  250000,  187500, 1,  50000,   5,  15),
               (1,  2,  2, 1, 100000, 10,  50000,  500000,  375000, 1, 100000,  15,  25),
               (2,  3,  3, 2, 150000, 15,  75000,  750000,  562500, 2, 150000,  25,  35),
               (2,  4,  4, 2, 200000, 20, 100000, 1000000,  750000, 2, 200000,  35,  45),
               (3,  5,  5, 3, 250000, 25, 125000, 1250000,  937500, 3, 250000,  45,  55),
               (3,  6,  6, 3, 300000, 30, 150000, 1500000, 1125000, 3, 300000,  55,  65),
               (4,  7,  7, 4, 350000, 35, 175000, 1750000, 1312500, 4, 350000,  65,  75),
               (4,  8,  8, 4, 400000, 40, 200000, 2000000, 1500000, 4, 400000,  75,  85),
               (5,  9,  9, 5, 450000, 45, 225000, 2250000, 1687500, 5, 450000,  85,  95),
               (5, 10, 10, 5, 500000, 50, 250000, 2500000, 1875000, 5, 500000, 100, 100);';