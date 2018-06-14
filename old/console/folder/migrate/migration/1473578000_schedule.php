<?php

$q = array();

$q[] = 'CREATE TABLE `schedule`
        (
            `schedule_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `schedule_date` INT(11) DEFAULT 0,
            `schedule_season_id` INT(5) DEFAULT 0,
            `schedule_stage_id` INT(2) DEFAULT 0,
            `schedule_tournamenttype_id` INT(1) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `schedule_date` ON `schedule` (`schedule_date`);';
$q[] = 'CREATE INDEX `schedule_season_id` ON `schedule` (`schedule_season_id`);';
$q[] = 'CREATE INDEX `schedule_tournamenttype_id` ON `schedule` (`schedule_tournamenttype_id`);';