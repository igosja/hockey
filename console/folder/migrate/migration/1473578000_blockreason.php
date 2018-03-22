<?php

$q = array();

$q[] = 'CREATE TABLE `blockreason`
        (
            `blockreason_id` INT(2) PRIMARY KEY AUTO_INCREMENT,
            `blockreason_text` VARCHAR(255) DEFAULT 0
        );';