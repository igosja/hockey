<?php

$q = array();

$q[] = 'CREATE TABLE `style`
        (
            `style_id` TINYINT(1) PRIMARY KEY AUTO_INCREMENT,
            `style_name` VARCHAR(255) NOT NULL
        );';
$q[] = "INSERT INTO `style` (`style_name`)
        VALUES ('норма'),
               ('сила'),
               ('скорость'),
               ('техника');";