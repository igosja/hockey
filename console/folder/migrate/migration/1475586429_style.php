<?php

$q = array();

$q[] = 'CREATE TABLE `style`
        (
            `style_id` INT(1) PRIMARY KEY AUTO_INCREMENT,
            `style_name` VARCHAR(255)
        );';
$q[] = "INSERT INTO `style` (`style_name`)
        VALUES ('норма'),
               ('сила'),
               ('скорость'),
               ('техника');";