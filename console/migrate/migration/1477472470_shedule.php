<?php

$q = array();

$q[] = 'CREATE TABLE `shedule`
        (
            `shedule_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `shedule_date` INT(11) DEFAULT 0,
            `shedule_season_id` SMALLINT(5) DEFAULT 0,
            `shedule_tournamenttype_id` TINYINT(1) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `shedule_season_id` ON `shedule` (`shedule_season_id`);';
$q[] = 'CREATE INDEX `shedule_tournamenttype_id` ON `shedule` (`shedule_tournamenttype_id`);';