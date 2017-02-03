<?php

$q = array();

$q[] = 'CREATE TABLE `rentplayerspecial`
        (
            `rentplayerspecial_level` TINYINT(1) DEFAULT 0,
            `rentplayerspecial_player_id` INT(11) DEFAULT 0,
            `rentplayerspecial_special_id` TINYINT(2) DEFAULT 0
        );';