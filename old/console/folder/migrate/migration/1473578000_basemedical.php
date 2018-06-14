<?php

$q = array();

$q[] = 'CREATE TABLE `basemedical`
        (
            `basemedical_id` INT(2) PRIMARY KEY AUTO_INCREMENT,
            `basemedical_base_level` INT(2) DEFAULT 0,
            `basemedical_build_speed` INT(1) DEFAULT 0,
            `basemedical_level` INT(2) DEFAULT 0,
            `basemedical_price_buy` INT(11) DEFAULT 0,
            `basemedical_price_sell` INT(11) DEFAULT 0,
            `basemedical_tire` INT(2) DEFAULT 0
        );';
$q[] = 'INSERT INTO `basemedical`
        (
            `basemedical_base_level`,
            `basemedical_build_speed`,
            `basemedical_level`,
            `basemedical_price_buy`,
            `basemedical_price_sell`,
            `basemedical_tire`
        )
        VALUES (0,  0,  0,       0,       0, 50),
               (1,  1,  1,  250000,  187500, 45),
               (1,  2,  2,  500000,  375000, 40),
               (2,  3,  3,  750000,  562500, 35),
               (2,  4,  4, 1000000,  750000, 30),
               (3,  5,  5, 1250000,  937500, 25),
               (3,  6,  6, 1500000, 1125000, 20),
               (4,  7,  7, 1750000, 1312500, 15),
               (4,  8,  8, 2000000, 1500000, 10),
               (5,  9,  9, 2250000, 1687500,  5),
               (5, 10, 10, 2500000, 1875000,  0);';