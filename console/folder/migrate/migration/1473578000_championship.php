<?php

$q = array();

$q[] = 'CREATE TABLE `championship`
        (
            `championship_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `championship_country_id` INT(3) DEFAULT 0,
            `championship_difference` INT(3) DEFAULT 0,
            `championship_division_id` INT(1) DEFAULT 0,
            `championship_game` INT(2) DEFAULT 0,
            `championship_loose` INT(2) DEFAULT 0,
            `championship_loose_bullet` INT(2) DEFAULT 0,
            `championship_loose_over` INT(2) DEFAULT 0,
            `championship_pass` INT(3) DEFAULT 0,
            `championship_place` INT(2) DEFAULT 0,
            `championship_point` INT(2) DEFAULT 0,
            `championship_score` INT(3) DEFAULT 0,
            `championship_season_id` INT(5) DEFAULT 0,
            `championship_team_id` INT(5) DEFAULT 0,
            `championship_win` INT(2) DEFAULT 0,
            `championship_win_bullet` INT(2) DEFAULT 0,
            `championship_win_over` INT(2) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `championship_country_id` ON `championship` (`championship_country_id`);';
$q[] = 'CREATE INDEX `championship_division_id` ON `championship` (`championship_division_id`);';
$q[] = 'CREATE INDEX `championship_season_id` ON `championship` (`championship_season_id`);';
$q[] = 'CREATE INDEX `championship_team_id` ON `championship` (`championship_team_id`);';