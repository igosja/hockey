<?php

$q = array();

$q[] = 'CREATE TABLE `base`
        (
            `base_id` INT(2) PRIMARY KEY AUTO_INCREMENT,
            `base_build_speed` INT(2) DEFAULT 0,
            `base_level` INT(2) DEFAULT 0,
            `base_maintenance_base` INT(11) DEFAULT 0,
            `base_maintenance_slot` INT(11) DEFAULT 0,
            `base_price_buy` INT(11) DEFAULT 0,
            `base_price_sell` INT(11) DEFAULT 0,
            `base_slot_max` INT(2) DEFAULT 0,
            `base_slot_min` INT(2) DEFAULT 0
        );';
$q[] = 'INSERT INTO `base`
        (
            `base_build_speed`,
            `base_level`,
            `base_maintenance_base`,
            `base_maintenance_slot`,
            `base_price_buy`,
            `base_price_sell`,
            `base_slot_max`,
            `base_slot_min`
        )
        VALUES ( 0,  0,       0,      0,        0,       0,  0,  0),
               ( 2,  1,   50000,  25000,   500000,  375000,  5,  0),
               ( 4,  2,  100000,  50000,  1000000,  750000, 10,  3),
               ( 6,  3,  200000,  75000,  2000000, 1500000, 15,  8),
               ( 8,  4,  300000, 100000,  3000000, 2250000, 20, 13),
               (10,  5,  400000, 125000,  4000000, 3000000, 25, 18),
               (12,  6,  500000, 150000,  5000000, 3750000, 30, 23),
               (14,  7,  600000, 175000,  6000000, 4500000, 35, 28),
               (16,  8,  700000, 200000,  7000000, 5250000, 40, 33),
               (18,  9,  800000, 225000,  8000000, 6000000, 45, 38),
               (20, 10, 1000000, 250000, 10000000, 7500000, 50, 43);';