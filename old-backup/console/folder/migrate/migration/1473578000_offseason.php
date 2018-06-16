<?php

$q = array();

$q[] = 'CREATE TABLE `offseason`
        (
            `offseason_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `offseason_difference` INT(3) DEFAULT 0,
            `offseason_game` INT(2) DEFAULT 0,
            `offseason_guest` INT(2) DEFAULT 0,
            `offseason_home` INT(2) DEFAULT 0,
            `offseason_loose` INT(2) DEFAULT 0,
            `offseason_loose_bullet` INT(2) DEFAULT 0,
            `offseason_loose_over` INT(2) DEFAULT 0,
            `offseason_pass` INT(3) DEFAULT 0,
            `offseason_place` INT(5) DEFAULT 0,
            `offseason_point` INT(2) DEFAULT 0,
            `offseason_score` INT(3) DEFAULT 0,
            `offseason_season_id` INT(5) DEFAULT 0,
            `offseason_team_id` INT(5) DEFAULT 0,
            `offseason_win` INT(2) DEFAULT 0,
            `offseason_win_bullet` INT(2) DEFAULT 0,
            `offseason_win_over` INT(2) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `offseason_season_id` ON `offseason` (`offseason_season_id`);';
$q[] = 'CREATE INDEX `offseason_team_id` ON `offseason` (`offseason_team_id`);';