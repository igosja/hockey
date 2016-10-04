<?php

$q = array();

$q[] = 'CREATE TABLE `style`
        (
            `style_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `style_name` VARCHAR(255) NOT NULL
        );';