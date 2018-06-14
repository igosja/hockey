<?php

$q = array();

$q[] = 'CREATE TABLE `rentcomment`
        (
            `rentcomment_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `rentcomment_check` INT(1) DEFAULT 0,
            `rentcomment_date` INT(11) DEFAULT 0,
            `rentcomment_rent_id` INT(11) DEFAULT 0,
            `rentcomment_text` TEXT,
            `rentcomment_user_id` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `rentcomment_check` ON `rentcomment` (`rentcomment_check`);';
$q[] = 'CREATE INDEX `rentcomment_rent_id` ON `rentcomment` (`rentcomment_rent_id`);';