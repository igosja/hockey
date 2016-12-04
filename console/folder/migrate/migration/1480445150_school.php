<?php

$q = array();

$q[] = 'CREATE TABLE `school`
        (
            `school_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `school_day` TINYINT(2) DEFAULT 0,
            `school_position_id` TINYINT(1) DEFAULT 0,
            `school_season_id` SMALLINT(5) DEFAULT 0,
            `school_special_id` TINYINT(2) DEFAULT 0,
            `school_team_id` SMALLINT(5) DEFAULT 0
        );';