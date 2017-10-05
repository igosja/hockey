<?php

$q = array();

$q[] = 'CREATE TABLE `league`
        (
            `league_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `league_difference` INT(2) DEFAULT 0,
            `league_game` INT(1) DEFAULT 0,
            `league_group` INT(1) DEFAULT 0,
            `league_loose` INT(1) DEFAULT 0,
            `league_loose_bullet` INT(1) DEFAULT 0,
            `league_loose_over` INT(1) DEFAULT 0,
            `league_pass` INT(2) DEFAULT 0,
            `league_place` INT(1) DEFAULT 0,
            `league_point` INT(2) DEFAULT 0,
            `league_score` INT(2) DEFAULT 0,
            `league_season_id` INT(5) DEFAULT 0,
            `league_team_id` INT(5) DEFAULT 0,
            `league_win` INT(2) DEFAULT 0,
            `league_win_bullet` INT(2) DEFAULT 0,
            `league_win_over` INT(2) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `league_group` ON `league` (`league_group`);';
$q[] = 'CREATE INDEX `league_season_id` ON `league` (`league_season_id`);';
$q[] = 'CREATE INDEX `league_team_id` ON `league` (`league_team_id`);';