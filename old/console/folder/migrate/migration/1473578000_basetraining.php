<?php

$q = array();

$q[] = 'CREATE TABLE `basetraining`
        (
            `basetraining_id` INT(2) PRIMARY KEY AUTO_INCREMENT,
            `basetraining_base_level` INT(2) DEFAULT 0,
            `basetraining_build_speed` INT(2) DEFAULT 0,
            `basetraining_level` INT(2) DEFAULT 0,
            `basetraining_position_count` INT(2) DEFAULT 0,
            `basetraining_position_price` INT(11) DEFAULT 0,
            `basetraining_power_count` INT(2) DEFAULT 0,
            `basetraining_power_price` INT(11) DEFAULT 0,
            `basetraining_price_buy` INT(11) DEFAULT 0,
            `basetraining_price_sell` INT(11) DEFAULT 0,
            `basetraining_special_count` INT(2) DEFAULT 0,
            `basetraining_special_price` INT(11) DEFAULT 0,
            `basetraining_training_speed_max` INT(3) DEFAULT 0,
            `basetraining_training_speed_min` INT(3) DEFAULT 0
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
               (1,  1,  1, 1,  50000,  5,  25000,  250000,  187500, 1,  50000,  15,   5),
               (1,  2,  2, 1, 100000, 10,  50000,  500000,  375000, 1, 100000,  25,  15),
               (2,  3,  3, 2, 150000, 15,  75000,  750000,  562500, 2, 150000,  35,  25),
               (2,  4,  4, 2, 200000, 20, 100000, 1000000,  750000, 2, 200000,  45,  35),
               (3,  5,  5, 3, 250000, 25, 125000, 1250000,  937500, 3, 250000,  55,  45),
               (3,  6,  6, 3, 300000, 30, 150000, 1500000, 1125000, 3, 300000,  65,  55),
               (4,  7,  7, 4, 350000, 35, 175000, 1750000, 1312500, 4, 350000,  75,  65),
               (4,  8,  8, 4, 400000, 40, 200000, 2000000, 1500000, 4, 400000,  85,  75),
               (5,  9,  9, 5, 450000, 45, 225000, 2250000, 1687500, 5, 450000,  95,  85),
               (5, 10, 10, 5, 500000, 50, 250000, 2500000, 1875000, 5, 500000, 100, 100);';