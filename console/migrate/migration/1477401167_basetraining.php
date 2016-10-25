<?php

$q[] = 'CREATE TABLE `basetraining`
        (
            `basetraining_id` TINYINT(2) PRIMARY KEY AUTO_INCREMENT,
            `basetraining_base_id` TINYINT(2) DEFAULT 0,
            `basetraining_build_speed` TINYINT(1) DEFAULT 0,
            `basetraining_position_count` TINYINT(2) DEFAULT 0,
            `basetraining_position_price` INT(11) DEFAULT 0,
            `basetraining_power_count` TINYINT(2) DEFAULT 0,
            `basetraining_power_price` INT(11) DEFAULT 0,
            `basetraining_price_buy` INT(11) DEFAULT 0,
            `basetraining_price_sell` INT(11) DEFAULT 0,
            `basetraining_special_count` TINYINT(2) DEFAULT 0,
            `basetraining_special_price` INT(11) DEFAULT 0,
            `basetraining_together` TINYINT(1) DEFAULT 0,
            `basetraining_training_speed_max` TINYINT(3) DEFAULT 0,
            `basetraining_training_speed_min` TINYINT(3) DEFAULT 0
        );';
$q[] = 'INSERT INTO `basetraining`
        (
            `basetraining_base_id`,
            `basetraining_build_speed`,
            `basetraining_position_count`,
            `basetraining_position_price`,
            `basetraining_power_count`,
            `basetraining_power_price`,
            `basetraining_price_buy`,
            `basetraining_price_sell`,
            `basetraining_special_count`,
            `basetraining_special_price`,
            `basetraining_together`,
            `basetraining_training_speed_max`,
            `basetraining_training_speed_min`
        )
        VALUES (1,  1,   500000,  375000,  5,  0,  2),
               (1,  2,  1000000,  750000, 10,  3,  4),
               (2,  3,  2000000, 1500000, 15,  8,  6),
               (2,  4,  3000000, 2250000, 20, 13,  8),
               (3,  5,  4000000, 3000000, 25, 18, 10),
               (3,  6,  5000000, 3750000, 30, 23, 12),
               (4,  7,  6000000, 4500000, 35, 28, 14),
               (4,  8,  7000000, 5250000, 40, 33, 16),
               (5,  9,  8000000, 6000000, 45, 38, 18),
               (5, 10, 10000000, 7500000, 50, 43, 20);';