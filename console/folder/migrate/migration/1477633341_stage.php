<?php

$q = array();

$q[] = 'CREATE TABLE `stage`
        (
            `stage_id` INT(1) PRIMARY KEY AUTO_INCREMENT,
            `stage_name` VARCHAR(255) NOT NULL,
            `stage_visitor` INT(3)
        );';
$q[] = "INSERT INTO `stage` (`stage_name`, `stage_visitor`)
        VALUES ('-', 90),
               ('1 тур', 100),
               ('2 тур', 100),
               ('3 тур', 100),
               ('4 тур', 100),
               ('5 тур', 100),
               ('6 тур', 100),
               ('7 тур', 100),
               ('8 тур', 100),
               ('9 тур', 100),
               ('10 тур', 100),
               ('11 тур', 100),
               ('12 тур', 100),
               ('13 тур', 100),
               ('14 тур', 100),
               ('15 тур', 100),
               ('16 тур', 100),
               ('17 тур', 100),
               ('18 тур', 100),
               ('19 тур', 100),
               ('20 тур', 100),
               ('21 тур', 100),
               ('22 тур', 100),
               ('23 тур', 100),
               ('24 тур', 100),
               ('25 тур', 100),
               ('26 тур', 100),
               ('27 тур', 100),
               ('28 тур', 100),
               ('29 тур', 100),
               ('30 тур', 100),
               ('31 тур', 100),
               ('32 тур', 100),
               ('33 тур', 100),
               ('34 тур', 100),
               ('35 тур', 100),
               ('36 тур', 100),
               ('37 тур', 100),
               ('38 тур', 100),
               ('39 тур', 100),
               ('40 тур', 100),
               ('41 тур', 100),
               ('ОР1', 105),
               ('ОР2', 105),
               ('ОР3', 105),
               ('ОР4', 105),
               ('1/512', 110),
               ('1/256', 120),
               ('1/128', 130),
               ('1/64', 140),
               ('1/32', 150),
               ('1/16', 160),
               ('1/8', 170),
               ('1/4', 180),
               ('1/2', 190),
               ('Финал', 200);";