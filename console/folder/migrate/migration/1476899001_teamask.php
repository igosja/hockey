<?php

$q = array();

$q[] = 'CREATE TABLE `teamask`
        (
            `teamask_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `teamask_date` INT(11) DEFAULT 0,
            `teamask_team_id` INT(11) DEFAULT 0,
            `teamask_user_id` INT(11) DEFAULT 0
        );';