<?php

$q = array();

$q[] = 'CREATE TABLE `message`
        (
            `message_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `message_date` INT(11) DEFAULT 0,
            `message_delete_from` INT(1) DEFAULT 0,
            `message_delete_to` INT(1) DEFAULT 0,
            `message_read` INT(1) DEFAULT 0,
            `message_support_from` INT(1) DEFAULT 0,
            `message_support_to` INT(1) DEFAULT 0,
            `message_text` TEXT,
            `message_user_id_from` INT(11) DEFAULT 0,
            `message_user_id_to` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `message_read` ON `message` (`message_read`);';
$q[] = 'CREATE INDEX `message_support_from` ON `message` (`message_support_from`);';
$q[] = 'CREATE INDEX `message_support_to` ON `message` (`message_support_to`);';
$q[] = 'CREATE INDEX `message_user_id_from` ON `message` (`message_user_id_from`);';
$q[] = 'CREATE INDEX `message_user_id_to` ON `message` (`message_user_id_to`);';