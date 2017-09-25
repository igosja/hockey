<?php

$q = array();

$q[] = 'CREATE TABLE `debug`
        (
            `debug_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `debug_sql` TEXT,
            `debug_time` DECIMAL(7,2) DEFAULT 0
        );';