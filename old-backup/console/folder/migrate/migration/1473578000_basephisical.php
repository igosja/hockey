<?php

$q = array();

$q[] = 'CREATE TABLE `basephisical`
        (
            `basephisical_id` INT(2) PRIMARY KEY AUTO_INCREMENT,
            `basephisical_base_level` INT(2) DEFAULT 0,
            `basephisical_build_speed` INT(2) DEFAULT 0,
            `basephisical_change_count` INT(2) DEFAULT 0,
            `basephisical_level` INT(2) DEFAULT 0,
            `basephisical_price_buy` INT(11) DEFAULT 0,
            `basephisical_price_sell` INT(11) DEFAULT 0,
            `basephisical_tire_bonus` INT(1) DEFAULT 0
        );';
$q[] = 'INSERT INTO `basephisical`
        (
            `basephisical_base_level`,
            `basephisical_build_speed`,
            `basephisical_change_count`,
            `basephisical_level`,
            `basephisical_price_buy`,
            `basephisical_price_sell`,
            `basephisical_tire_bonus`
        )
        VALUES (0,  0,  0,  0,       0,       0,  2),
               (1,  1,  5,  1,  250000,  187500,  1),
               (1,  2, 10,  2,  500000,  375000,  1),
               (2,  3, 15,  3,  750000,  562500,  0),
               (2,  4, 20,  4, 1000000,  750000,  0),
               (3,  5, 25,  5, 1250000,  937500, -1),
               (3,  6, 30,  6, 1500000, 1125000, -1),
               (4,  7, 35,  7, 1750000, 1312500, -2),
               (4,  8, 40,  8, 2000000, 1500000, -2),
               (5,  9, 45,  9, 2250000, 1687500, -3),
               (5, 10, 50, 10, 2500000, 1875000, -3);';