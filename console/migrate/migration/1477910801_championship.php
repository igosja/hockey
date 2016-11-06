<?php

$q = array();

$q[] = 'CREATE TABLE `championship`
        (
            `championship_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `championship_country_id` SMALLINT(3) DEFAULT 0,
            `championship_division_id` TINYINT(1) DEFAULT 0,
            `championship_game` TINYINT(2) DEFAULT 0,
            `championship_loose` TINYINT(2) DEFAULT 0,
            `championship_loose_over` TINYINT(2) DEFAULT 0,
            `championship_pass` SMALLINT(3) DEFAULT 0,
            `championship_place` TINYINT(2) DEFAULT 0,
            `championship_point` TINYINT(2) DEFAULT 0,
            `championship_score` SMALLINT(3) DEFAULT 0,
            `championship_season_id` SMALLINT(5) DEFAULT 0,
            `championship_team_id` SMALLINT(5) DEFAULT 0,
            `championship_win` TINYINT(2) DEFAULT 0,
            `championship_win_over` TINYINT(2) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `championship_country_id` ON `championship` (`championship_country_id`);';
$q[] = 'CREATE INDEX `championship_division_id` ON `championship` (`championship_division_id`);';
$q[] = 'CREATE INDEX `championship_place` ON `championship` (`championship_place`);';
$q[] = 'CREATE INDEX `championship_season_id` ON `championship` (`championship_season_id`);';
$q[] = 'CREATE INDEX `championship_team_id` ON `championship` (`championship_team_id`);';