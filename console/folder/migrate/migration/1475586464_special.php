<?php

$q = array();

$q[] = 'CREATE TABLE `special`
        (
            `special_id` TINYINT(2) PRIMARY KEY AUTO_INCREMENT,
            `special_field` VARCHAR(255) NOT NULL,
            `special_gk` VARCHAR(255) NOT NULL,
            `special_name` VARCHAR(255) NOT NULL,
            `special_short` VARCHAR(2) NOT NULL
        );';
$q[] = "INSERT INTO `special` (`special_field`, `special_gk`, `special_name`, `special_short`)
        VALUES (1, 0, 'Скорость', 'Ск'),
               (1, 0, 'Силовая борьба', 'Сб'),
               (1, 0, 'Техника', 'Т'),
               (1, 1, 'Лидер', 'Л'),
               (1, 1, 'Атлетизм', 'Ат'),
               (0, 1, 'Реакция', 'Р'),
               (1, 0, 'Отбор', 'От'),
               (1, 0, 'Бросок', 'Бр');";