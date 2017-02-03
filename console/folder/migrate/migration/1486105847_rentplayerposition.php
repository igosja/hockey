<?php

$q = array();

$q[] = 'CREATE TABLE `rentplayerposition`
        (
            `rentplayerposition_player_id` INT(11) DEFAULT 0,
            `rentplayerposition_position_id` TINYINT(1) DEFAULT 0
        );';