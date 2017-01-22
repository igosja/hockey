<?php

$q = array();

$q[] = 'CREATE TABLE `special`
        (
            `special_id` TINYINT(2) PRIMARY KEY AUTO_INCREMENT,
            `special_name` VARCHAR(255) NOT NULL,
            `special_short` VARCHAR(2) NOT NULL
        );';
$q[] = "INSERT INTO `special` (`special_name`, `special_short`)
        VALUES ('Скорость', 'Ск'),
               ('Силовая борьба', 'Сб'),
               ('Комбинирование', 'Км'),
               ('Лидер', 'Л'),
               ('Атлетизм', 'Ат'),
               ('Реакция', 'Р'),
               ('Игра на пятачке', 'Ип'),
               ('Отбор', 'От'),
               ('Бросок', 'Бр');";