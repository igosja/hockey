<?php

$q = array();

$q[] = 'CREATE TABLE `scout`
        (
            `scout_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `scout_percent` INT(3) DEFAULT 0,
            `scout_player_id` INT(11) DEFAULT 0,
            `scout_ready` INT(1) DEFAULT 0,
            `scout_season_id` INT(2) DEFAULT 0,
            `scout_style` INT(1) DEFAULT 0,
            `scout_team_id` INT(5) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `scout_ready` ON `scout` (`scout_ready`);';
$q[] = 'CREATE INDEX `scout_season_id` ON `scout` (`scout_season_id`);';
$q[] = 'CREATE INDEX `scout_team_id` ON `scout` (`scout_team_id`);';