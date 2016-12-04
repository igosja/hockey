<?php

$q = array();

$q[] = 'CREATE TABLE `construnctiontype`
        (
            `construnctiontype_id` TINYINT(1) PRIMARY KEY AUTO_INCREMENT,
            `construnctiontype_name` VARCHAR(255) NOT NULL
        );';
$q[] = "INSERT INTO `construnctiontype` (`construnctiontype_name`)
        VALUES ('Строительство'),
               ('Разрушение');";