<?php

$q = array();

$q[] = 'CREATE TABLE `transfercomment`
        (
            `transfercomment_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `transfercomment_check` INT(1) DEFAULT 0,
            `transfercomment_date` INT(11) DEFAULT 0,
            `transfercomment_transfer_id` INT(11) DEFAULT 0,
            `transfercomment_text` TEXT,
            `transfercomment_user_id` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `transfercomment_check` ON `transfercomment` (`transfercomment_check`);';
$q[] = 'CREATE INDEX `transfercomment_transfer_id` ON `transfercomment` (`transfercomment_transfer_id`);';