<?php

$q = array();

$q[] = 'CREATE TABLE `ratingchapter`
        (
            `ratingchapter_id` INT(1) PRIMARY KEY AUTO_INCREMENT,
            `ratingchapter_name` VARCHAR(255) NOT NULL
        );';
$q[] = "INSERT INTO `ratingchapter` (`ratingchapter_name`)
        VALUES ('Команды'),
               ('Менеджеры'),
               ('Страны');";