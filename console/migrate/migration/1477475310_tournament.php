<?php

$q = array();

$q[] = 'CREATE TABLE `tournament`
        (
            `tournament_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `tournament_name` VARCHAR(255) NOT NULL,
            `tournament_tournamenttype_id` TINYINT(1) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `tournament_tournamenttype_id` ON `tournament` (`tournament_tournamenttype_id`);';