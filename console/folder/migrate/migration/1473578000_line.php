<?php

$q = array();

$q[] = 'CREATE TABLE `line`
        (
            `line_id` INT(1) PRIMARY KEY AUTO_INCREMENT,
            `line_color` CHAR(6),
            `line_name` VARCHAR(255)
        );';
$q[] = "INSERT INTO `line` (`line_color`, `line_name`)
        VALUES ('', '------'),
               ('DFF2BF', '1 состав'),
               ('BDE5F8', '2 состав'),
               ('FEEFB3', '3 состав'),
               ('FFBABA', '4 состав'),
               ('E0E0E0', '5 состав');";