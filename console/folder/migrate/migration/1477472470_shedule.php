<?php

$q = array();

$q[] = 'CREATE TABLE `shedule`
        (
            `shedule_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `shedule_date` INT(11) DEFAULT 0,
            `shedule_nationalvotestep_id` INT(1) DEFAULT 0,
            `shedule_season_id` INT(5) DEFAULT 0,
            `shedule_stage_id` INT(2) DEFAULT 0,
            `shedule_tournamenttype_id` INT(1) DEFAULT 0
        );';