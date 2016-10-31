<?php

$q = array();

$q[] = 'CREATE TABLE `league`
        (
            `league_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `league_game` TINYINT(1) DEFAULT 0,
            `league_group` TINYINT(1) DEFAULT 0,
            `league_loose` TINYINT(1) DEFAULT 0,
            `league_loose_over` TINYINT(1) DEFAULT 0,
            `league_pass` TINYINT(2) DEFAULT 0,
            `league_place` TINYINT(1) DEFAULT 0,
            `league_point` TINYINT(2) DEFAULT 0,
            `league_score` TINYINT(2) DEFAULT 0,
            `league_season_id` SMALLINT(5) DEFAULT 0,
            `league_team_id` SMALLINT(5) DEFAULT 0,
            `league_win` TINYINT(2) DEFAULT 0,
            `league_win_over` TINYINT(2) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `league_group` ON `league` (`league_group`);';
$q[] = 'CREATE INDEX `league_season_id` ON `league` (`league_season_id`);';
$q[] = 'CREATE INDEX `league_team_id` ON `league` (`league_team_id`);';