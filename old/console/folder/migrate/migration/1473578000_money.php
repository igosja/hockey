<?php

$q = array();

$q[] = 'CREATE TABLE `money`
        (
            `money_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `money_date` INT(11) DEFAULT 0,
            `money_moneytext_id` INT(2) DEFAULT 0,
            `money_user_id` INT(11) DEFAULT 0,
            `money_value` INT(11) DEFAULT 0,
            `money_value_after` INT(11) DEFAULT 0,
            `money_value_before` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `money_user_id` ON `money` (`money_user_id`);';