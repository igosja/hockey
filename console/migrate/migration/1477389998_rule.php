<?php

$q = array();

$q[] = 'CREATE TABLE `rule`
        (
            `rule_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `rule_date` INT(11) DEFAULT 0,
            `rule_order` INT(11) DEFAULT 0,
            `rule_text` TEXT NOT NULL,
            `rule_title` VARCHAR(255) NOT NULL
        );';
$q[] = 'CREATE INDEX `rule_order` ON `rule` (`rule_order`);';