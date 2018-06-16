<?php

$q = array();

$q[] = 'CREATE TABLE `city`
        (
            `city_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `city_country_id` INT(3) DEFAULT 0,
            `city_name` VARCHAR(255)
        );';
$q[] = 'CREATE INDEX `city_country_id` ON `city` (`city_country_id`);';
$q[] = "INSERT INTO `city`
        SET `city_country_id`=0,
            `city_name`='VHOL'";
$q[] = "UPDATE `city`
        SET `city_id`=0
        WHERE `city_id`=1
        LIMIT 1";
$q[] = "ALTER TABLE `city` AUTO_INCREMENT=1";