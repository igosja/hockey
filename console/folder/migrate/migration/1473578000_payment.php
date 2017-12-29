<?php

$q = array();

$q[] = 'CREATE TABLE `payment`
        (
            `payment_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `payment_date` INT(1) DEFAULT 0,
            `payment_status` INT(1) DEFAULT 0,
            `payment_sum` DECIMAL(11,2) DEFAULT 0,
            `payment_user_id` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `payment_status` ON `payment` (`payment_status`);';