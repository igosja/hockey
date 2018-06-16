<?php

$q = array();

$q[] = 'CREATE TABLE `forummessage`
        (
            `forummessage_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `forummessage_blocked` INT(1) DEFAULT 0,
            `forummessage_check` INT(11) DEFAULT 0,
            `forummessage_date` INT(11) DEFAULT 0,
            `forummessage_date_update` INT(11) DEFAULT 0,
            `forummessage_forumtheme_id` INT(11) DEFAULT 0,
            `forummessage_text` TEXT,
            `forummessage_user_id` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `forummessage_check` ON `forummessage` (`forummessage_check`);';
$q[] = 'CREATE INDEX `forummessage_forumtheme_id` ON `forummessage` (`forummessage_forumtheme_id`);';