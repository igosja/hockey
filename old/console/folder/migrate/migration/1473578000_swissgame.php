<?php

$q = array();

$q[] = 'CREATE TABLE `swissgame`
        (
            `swissgame_guest_team_id` INT(11) DEFAULT 0,
            `swissgame_home_team_id` INT(11) DEFAULT 0
        );';