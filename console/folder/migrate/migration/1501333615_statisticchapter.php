<?php

$q = array();

$q[] = 'CREATE TABLE `statisticchapter`
        (
            `statisticchapter_id` INT(1) PRIMARY KEY AUTO_INCREMENT,
            `statisticchapter_name` VARCHAR(255),
            `statisticchapter_order` INT(1) DEFAULT 0
        );';
$q[] = "INSERT INTO `statisticchapter` (`statisticchapter_name`)
        VALUES ('Команды'),
               ('Хоккеисты');";