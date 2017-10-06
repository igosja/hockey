<?php

$q = array();

$q[] = 'CREATE TABLE `phisical`
        (
            `phisical_id` INT(2) PRIMARY KEY AUTO_INCREMENT,
            `phisical_opposite` INT(2) DEFAULT 0,
            `phisical_value` INT(3) DEFAULT 0
        );';
$q[] = "INSERT INTO `phisical` (`phisical_opposite`, `phisical_value`)
        VALUES (1, 125),
               (20, 120),
               (19, 115),
               (18, 110),
               (17, 105),
               (16, 100),
               (15, 95),
               (14, 90),
               (13, 85),
               (12, 80),
               (11, 75),
               (10, 80),
               (9, 85),
               (8, 90),
               (7, 95),
               (6, 100),
               (5, 105),
               (4, 110),
               (3, 115),
               (2, 120);";