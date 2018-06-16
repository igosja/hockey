<?php

$q = array();

$q[] = 'CREATE TABLE `stadium`
        (
            `stadium_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `stadium_capacity` INT(5) DEFAULT 100,
            `stadium_city_id` INT(11) DEFAULT 0,
            `stadium_maintenance` INT(6) DEFAULT 398,
            `stadium_name` VARCHAR(255)
        );';
$q[] = "INSERT INTO `stadium`
        SET `stadium_city_id`=0,
            `stadium_name`='VHOL'";
$q[] = "UPDATE `stadium`
        SET `stadium_id`=0
        WHERE `stadium_id`=1
        LIMIT 1";
$q[] = "ALTER TABLE `stadium` AUTO_INCREMENT=1";