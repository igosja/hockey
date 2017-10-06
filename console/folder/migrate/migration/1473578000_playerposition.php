<?php

$q = array();

$q[] = 'CREATE TABLE `playerposition`
        (
            `playerposition_player_id` INT(11) DEFAULT 0,
            `playerposition_position_id` INT(1) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `playerposition_player_id` ON `playerposition` (`playerposition_player_id`);';
$q[] = 'CREATE INDEX `playerposition_position_id` ON `playerposition` (`playerposition_position_id`);';