<?php

$q = array();

$q[] = 'CREATE TABLE `ratingtype`
        (
            `ratingtype_id` INT(2) PRIMARY KEY AUTO_INCREMENT,
            `ratingtype_name` VARCHAR(255),
            `ratingtype_order` INT(2) DEFAULT 0,
            `ratingtype_ratingchapter_id` INT(1) DEFAULT 0
        );';
$q[] = "INSERT INTO `ratingtype` (`ratingtype_name`, `ratingtype_ratingchapter_id`)
        VALUES ('Сила состава', 1),
               ('Средний возраст', 1),
               ('Стадионы', 1),
               ('Посещаемость', 1),
               ('Базы и строения', 1),
               ('Стоимость баз', 1),
               ('Стоимость стадионов', 1),
               ('Игроки', 1),
               ('Общая стоимость', 1),
               ('Рейтинг', 2),
               ('Стадионы', 3),
               ('Автосоставы', 3),
               ('Лига Чемпионов', 3);";