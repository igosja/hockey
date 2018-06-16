<?php

$q = array();

$q[] = 'CREATE TABLE `friendlystatus`
        (
            `friendlystatus_id` INT(1) PRIMARY KEY AUTO_INCREMENT,
            `friendlystatus_name` VARCHAR(255)
        );';
$q[] = "INSERT INTO `friendlystatus` (`friendlystatus_name`)
        VALUES ('Я принимаю любое приглашение'),
               ('Я самостоятельно выбираю соперников для моей команды'),
               ('Я не хочу принимать приглашения');";