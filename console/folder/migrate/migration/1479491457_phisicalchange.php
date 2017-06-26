<?php

$q = array();

$q[] = 'CREATE TABLE `phisicalchange`
        (
            `phisicalchange_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `phisicalchange_player_id` INT(11) DEFAULT 0,
            `phisicalchange_shedule_id` INT(11) DEFAULT 0,
            `phisicalchange_team_id` INT(5) DEFAULT 0
        );';