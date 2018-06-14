<?php

$q = array();

$q[] = 'CREATE TABLE `transfervote`
        (
            `transfervote_rating` INT(2) DEFAULT 0,
            `transfervote_transfer_id` INT(11) DEFAULT 0,
            `transfervote_user_id` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `transfervote_transfer_id` ON `transfervote` (`transfervote_transfer_id`);';
$q[] = 'CREATE INDEX `transfervote_user_id` ON `transfervote` (`transfervote_user_id`);';