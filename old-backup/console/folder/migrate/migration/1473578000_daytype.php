<?php

$q = array();

$q[] = 'CREATE TABLE `daytype`
        (
            `daytype_id` INT(1) PRIMARY KEY AUTO_INCREMENT,
            `daytype_name` VARCHAR(1),
            `daytype_text` VARCHAR(255)
        );';

$q[] = "INSERT INTO `daytype` (`daytype_name`, `daytype_text`)
        VALUES ('A', 'Тренировочные матчи'),
               ('B', 'Обязательные матчи'),
               ('C', 'Дополнительные матчи');";