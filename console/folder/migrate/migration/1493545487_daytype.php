<?php

$q = array();

$q[] = 'CREATE TABLE `daytype`
        (
            `daytype_id` TINYINT(1) PRIMARY KEY AUTO_INCREMENT,
            `daytype_name` VARCHAR(1) NOT NULL,
            `daytype_text` VARCHAR(255) NOT NULL
        );';

$q[] = "INSERT INTO `daytype` (`daytype_name`, `daytype_text`)
        VALUES ('A', 'Тренировочные матчи'),
               ('B', 'Обязательные матчи'),
               ('C', 'Дополнительные матчи');";