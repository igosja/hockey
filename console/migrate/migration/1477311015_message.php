<?php

$q = array();

$q[] = 'CREATE TABLE `message`
        (
            `message_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `message_date` INT(11) DEFAULT 0,
            `message_delete_from` TINYINT(1) DEFAULT 0,
            `message_delete_to` TINYINT(1) DEFAULT 0,
            `message_read` TINYINT(1) DEFAULT 0,
            `message_support_from` TINYINT(1) DEFAULT 0,
            `message_support_to` TINYINT(1) DEFAULT 0,
            `message_text` TEXT NOT NULL,
            `message_user_id_from` INT(11) DEFAULT 0,
            `message_user_id_to` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `message_delete_from` ON `message` (`message_delete_from`);';
$q[] = 'CREATE INDEX `message_delete_to` ON `message` (`message_delete_to`);';
$q[] = 'CREATE INDEX `message_support_from` ON `message` (`message_support_from`);';
$q[] = 'CREATE INDEX `message_support_to` ON `message` (`message_support_to`);';
$q[] = 'CREATE INDEX `message_user_id_from` ON `message` (`message_user_id_from`);';
$q[] = 'CREATE INDEX `message_user_id_to` ON `message` (`message_user_id_to`);';