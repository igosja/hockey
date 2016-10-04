<?php

$q = array();

$q[] = 'CREATE TABLE `playerspecial`
        (
            `playerspecial_player_id` INT(11) DEFAULT 0,
            `playerspecial_special_id` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `playerspecial_player_id` ON `playerspecial` (`playerspecial_player_id`);';
$q[] = 'CREATE INDEX `playerspecial_special_id` ON `playerspecial` (`playerspecial_special_id`);';