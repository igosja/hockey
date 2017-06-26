<?php

$q = array();

$q[] = 'CREATE TABLE `baseschool`
        (
            `baseschool_id` INT(2) PRIMARY KEY AUTO_INCREMENT,
            `baseschool_base_level` INT(2) DEFAULT 0,
            `baseschool_build_speed` INT(2) DEFAULT 0,
            `baseschool_level` INT(2) DEFAULT 0,
            `baseschool_player_count` INT(1) DEFAULT 0,
            `baseschool_power` INT(2) DEFAULT 0,
            `baseschool_price_buy` INT(11) DEFAULT 0,
            `baseschool_price_sell` INT(11) DEFAULT 0,
            `baseschool_school_speed` INT(2) DEFAULT 0,
            `baseschool_with_special` INT(1) DEFAULT 0,
            `baseschool_with_style` INT(1) DEFAULT 0
        );';
$q[] = 'INSERT INTO `baseschool`
        (
            `baseschool_base_level`,
            `baseschool_build_speed`,
            `baseschool_level`,
            `baseschool_player_count`,
            `baseschool_power`,
            `baseschool_price_buy`,
            `baseschool_price_sell`,
            `baseschool_school_speed`,
            `baseschool_with_special`,
            `baseschool_with_style`
        )
        VALUES (0,  0,  0, 0,  0,       0,       0,  0, 0, 0),
               (1,  1,  1, 2, 34,  250000,  187500, 14, 0, 0),
               (1,  2,  2, 2, 36,  500000,  375000, 14, 0, 0),
               (2,  3,  3, 2, 38,  750000,  562500, 13, 1, 0),
               (2,  4,  4, 2, 40, 1000000,  750000, 13, 1, 0),
               (3,  5,  5, 2, 42, 1250000,  937500, 12, 2, 0),
               (3,  6,  6, 2, 44, 1500000, 1125000, 12, 2, 0),
               (4,  7,  7, 2, 46, 1750000, 1312500, 11, 2, 1),
               (4,  8,  8, 2, 48, 2000000, 1500000, 11, 2, 1),
               (5,  9,  9, 2, 50, 2250000, 1687500, 10, 2, 2),
               (5, 10, 10, 2, 52, 2500000, 1875000, 10, 2, 2);';