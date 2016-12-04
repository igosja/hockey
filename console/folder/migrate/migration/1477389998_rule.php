<?php

$q = array();

$q[] = 'CREATE TABLE `rule`
        (
            `rule_id` TINYINT(3) PRIMARY KEY AUTO_INCREMENT,
            `rule_date` INT(11) DEFAULT 0,
            `rule_order` TINYINT(3) DEFAULT 0,
            `rule_text` TEXT NOT NULL,
            `rule_title` VARCHAR(255) NOT NULL
        );';