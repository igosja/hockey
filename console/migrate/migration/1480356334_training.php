<?php

$q = array();

$q[] = 'CREATE TABLE `training`
        (
            `training_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `training_percent` TINYINT(3) DEFAULT 0,
            `training_player_id` INT(11) DEFAULT 0,
            `training_position_id` TINYINT(1) DEFAULT 0,
            `training_power` TINYINT(1) DEFAULT 0,
            `training_season_id` TINYINT(2) DEFAULT 0,
            `training_special_id` TINYINT(2) DEFAULT 0,
            `training_team_id` SMALLINT(5) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `training_team_id` ON `training` (`training_team_id`);';
$q[] = 'CREATE INDEX `training_percent` ON `training` (`training_percent`);';
$q[] = 'CREATE INDEX `training_player_id` ON `training` (`training_player_id`);';
$q[] = 'CREATE INDEX `training_season_id` ON `training` (`training_season_id`);';