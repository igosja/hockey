<?php

$q = array();

$q[] = 'CREATE TABLE `nationaluserday`
        (
            `nationaluserday_day` INT(2) DEFAULT 0,
            `nationaluserday_national_id` INT(11) DEFAULT 0,
            `nationaluserday_user_id` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `nationaluserday_national_id` ON `nationaluserday` (`nationaluserday_national_id`)';