<?php

$q = array();

$q[] = 'CREATE TABLE `userrole`
        (
            `userrole_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `userrole_name` VARCHAR(255) NOT NULL
        );';