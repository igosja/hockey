<?php

$q = array();

$q[] = 'CREATE TABLE `playerspecial`
        (
            `playerspecial_level` INT(1) DEFAULT 0,
            `playerspecial_player_id` INT(11) DEFAULT 0,
            `playerspecial_special_id` INT(2) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `playerspecial_player_id` ON `playerspecial` (`playerspecial_player_id`);';