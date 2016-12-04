<?php

$q = array();

$q[] = 'CREATE TABLE `playerspecial`
        (
            `playerspecial_level` TINYINT(1) DEFAULT 0,
            `playerspecial_player_id` INT(11) DEFAULT 0,
            `playerspecial_special_id` TINYINT(2) DEFAULT 0
        );';