<?php

$q = array();

$q[] = 'CREATE TABLE `phisicalchange`
        (
            `phisicalchange_player_id` INT(11) DEFAULT,
            `phisicalchange_shedule_id` INT(11) DEFAULT 0,
            `phisicalchange_team_id` SMALLINT(5) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `phisicalchange_player_id` ON `phisicalchange` (`phisicalchange_player_id`);';
$q[] = 'CREATE INDEX `phisicalchange_shedule_id` ON `phisicalchange` (`phisicalchange_shedule_id`);';
$q[] = 'CREATE INDEX `phisicalchange_team_id` ON `phisicalchange` (`phisicalchange_team_id`);';