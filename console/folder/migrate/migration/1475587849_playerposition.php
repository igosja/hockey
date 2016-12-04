<?php

$q = array();

$q[] = 'CREATE TABLE `playerposition`
        (
            `playerposition_player_id` INT(11) DEFAULT 0,
            `playerposition_position_id` TINYINT(1) DEFAULT 0
        );';