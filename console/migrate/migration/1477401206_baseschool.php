<?php

$q = array();

$q[] = 'CREATE TABLE `baseschool`
        (
            `baseschool_id` TINYINT(2) PRIMARY KEY AUTO_INCREMENT,
            `baseschool_base_id` TINYINT(2) DEFAULT 0,
            `baseschool_build_speed` TINYINT(2) DEFAULT 0,
            `baseschool_level` TINYINT(2) DEFAULT 0,
            `baseschool_player_count` TINYINT(1) DEFAULT 0,
            `baseschool_price_buy` INT(11) DEFAULT 0,
            `baseschool_price_sell` INT(11) DEFAULT 0,
            `baseschool_school_speed` TINYINT(2) DEFAULT 0,
            `baseschool_with_special` TINYINT(1) DEFAULT 0,
            `baseschool_with_style` TINYINT(1) DEFAULT 0
        );';
$q[] = 'INSERT INTO `baseschool`
        (
            `baseschool_base_id`,
            `baseschool_build_speed`,
            `baseschool_level`,
            `baseschool_player_count`,
            `baseschool_price_buy`,
            `baseschool_price_sell`,
            `baseschool_school_speed`,
            `baseschool_with_special`,
            `baseschool_with_style`
        )
        VALUES (0,  0,  0, 2,       0,       0,  0, 0, 0),
               (1,  1,  1, 2,  250000,  187500, 14, 0, 0),
               (1,  2,  2, 2,  500000,  375000, 12, 0, 0),
               (2,  3,  3, 2,  750000,  562500, 14, 1, 0),
               (2,  4,  4, 2, 1000000,  750000, 12, 1, 0),
               (3,  5,  5, 2, 1250000,  937500, 14, 2, 0),
               (3,  6,  6, 2, 1500000, 1125000, 12, 2, 0),
               (4,  7,  7, 2, 1750000, 1312500, 14, 2, 1),
               (4,  8,  8, 2, 2000000, 1500000, 12, 2, 1),
               (5,  9,  9, 2, 2250000, 1687500, 14, 2, 2),
               (5, 10, 10, 2, 2500000, 1875000, 12, 2, 2);';