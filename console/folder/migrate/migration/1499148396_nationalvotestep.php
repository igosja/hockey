<?php

$q = array();

$q[] = 'CREATE TABLE `nationalvotestep`
        (
            `nationalvotestep_id` INT(1) PRIMARY KEY AUTO_INCREMENT,
            `nationalvotestep_name` VARCHAR(255)
        );';
$q[] = "INSERT INTO `nationalvotestep`
        SET `nationalvotestep_name`=''";
$q[] = "UPDATE `nationalvotestep`
        SET `nationalvotestep_id`=0
        WHERE `nationalvotestep_id`=1
        LIMIT 1";
$q[] = "ALTER TABLE `nationalvotestep` AUTO_INCREMENT=1";
$q[] = "INSERT INTO `nationalvotestep` (`nationalvotestep_name`)
        VALUES ('Подача заявок на тренера национальной сборной'),
               ('Выборы тренера национальной сборной'),
               ('Подача заявок на тренера сборной U-21'),
               ('Выборы тренера сборной U-21'),
               ('Подача заявок на тренера сборной U-19'),
               ('Выборы тренера сборной U-19');";