<?php

$q = array();

$q[] = 'CREATE TABLE `construnctiontype`
        (
            `construnctiontype_id` INT(1) PRIMARY KEY AUTO_INCREMENT,
            `construnctiontype_name` VARCHAR(255)
        );';
$q[] = "INSERT INTO `construnctiontype` (`construnctiontype_name`)
        VALUES ('Строительство'),
               ('Разрушение');";