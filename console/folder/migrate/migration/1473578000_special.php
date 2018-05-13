<?php

$q = array();

$q[] = 'CREATE TABLE `special`
        (
            `special_id` INT(2) PRIMARY KEY AUTO_INCREMENT,
            `special_field` INT(1) DEFAULT 0,
            `special_gk` INT(1) DEFAULT 0,
            `special_name` VARCHAR(255),
            `special_short` VARCHAR(2)
        );';
$q[] = "INSERT INTO `special` (`special_field`, `special_gk`, `special_name`, `special_short`)
        VALUES (1, 0, 'Скорость', 'Ск'),
               (1, 0, 'Силовая борьба', 'Сб'),
               (1, 0, 'Техника', 'Т'),
               (1, 1, 'Лидер', 'Л'),
               (1, 1, 'Атлетизм', 'Ат'),
               (0, 1, 'Реакция', 'Р'),
               (1, 0, 'Отбор', 'От'),
               (1, 0, 'Бросок', 'Бр'),
               (1, 1, 'Кумир', 'К'),
               (0, 1, 'Игра клюшкой', 'Кл'),
               (0, 1, 'Выбор позиции', 'П');";