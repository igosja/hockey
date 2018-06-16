<?php

$q = array();

$q[] = 'CREATE TABLE `rentvote`
        (
            `rentvote_rating` INT(2) DEFAULT 0,
            `rentvote_rent_id` INT(11) DEFAULT 0,
            `rentvote_user_id` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `rentvote_rent_id` ON `rentvote` (`rentvote_rent_id`);';
$q[] = 'CREATE INDEX `rentvote_user_id` ON `rentvote` (`rentvote_user_id`);';