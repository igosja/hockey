<?php

$q = array();

$q[] = 'CREATE TABLE `transferplayerposition`
        (
            `transferplayerposition_player_id` INT(11) DEFAULT 0,
            `transferplayerposition_position_id` TINYINT(1) DEFAULT 0
        );';