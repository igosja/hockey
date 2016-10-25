<?php

$q = array();

$q[] = 'CREATE TABLE `base`
        (
            `base_id` TINYINT(2) PRIMARY KEY AUTO_INCREMENT,
            `base_build_speed` TINYINT(2) DEFAULT 0,
            `base_maintenance_base` INT(11) DEFAULT 0,
            `base_maintenance_slot` INT(11) DEFAULT 0,
            `base_price_buy` INT(11) DEFAULT 0,
            `base_price_sale` INT(11) DEFAULT 0,
            `base_slot_max` TINYINT(2) DEFAULT 0,
            `base_slot_min` TINYINT(2) DEFAULT 0
        );';
$q[] = 'INSERT INTO `base`
        (
            `base_maintenance_base`,
            `base_maintenance_slot`,
            `base_price_buy`,
            `base_price_sale`,
            `base_slot_max`,
            `base_slot_min`,
            `base_build_speed`
        )
        VALUES (  50000,  25000,   500000,  375000,  5,  0,  2),
               ( 100000,  50000,  1000000,  750000, 10,  3,  4),
               ( 200000,  75000,  2000000, 1500000, 15,  8,  6),
               ( 300000, 100000,  3000000, 2250000, 20, 13,  8),
               ( 400000, 125000,  4000000, 3000000, 25, 18, 10),
               ( 500000, 150000,  5000000, 3750000, 30, 23, 12),
               ( 600000, 175000,  6000000, 4500000, 35, 28, 14),
               ( 700000, 200000,  7000000, 5250000, 40, 33, 16),
               ( 800000, 225000,  8000000, 6000000, 45, 38, 18),
               (1000000, 250000, 10000000, 7500000, 50, 43, 20);';