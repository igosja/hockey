<?php

$q = array();

$q[] = 'CREATE TABLE `transferplayerspecial`
        (
            `transferplayerspecial_level` TINYINT(1) DEFAULT 0,
            `transferplayerspecial_player_id` INT(11) DEFAULT 0,
            `transferplayerspecial_special_id` TINYINT(2) DEFAULT 0
        );';