<?php

$q = array();

$q[] = 'CREATE TABLE `training`
        (
            `training_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `training_percent` INT(3) DEFAULT 0,
            `training_player_id` INT(11) DEFAULT 0,
            `training_position_id` INT(1) DEFAULT 0,
            `training_power` INT(1) DEFAULT 0,
            `training_ready` INT(1) DEFAULT 0,
            `training_season_id` INT(2) DEFAULT 0,
            `training_special_id` INT(2) DEFAULT 0,
            `training_team_id` INT(5) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `training_ready` ON `training` (`training_ready`);';
$q[] = 'CREATE INDEX `training_season_id` ON `training` (`training_season_id`);';
$q[] = 'CREATE INDEX `training_team_id` ON `training` (`training_team_id`);';