<?php

$q = array();

$q[] = 'CREATE TABLE `leaguecoefficient`
        (
            `leaguecoefficient_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `leaguecoefficient_country_id` INT(3) DEFAULT 0,
            `leaguecoefficient_loose` INT(2) DEFAULT 0,
            `leaguecoefficient_loose_bullet` INT(2) DEFAULT 0,
            `leaguecoefficient_loose_over` INT(2) DEFAULT 0,
            `leaguecoefficient_point` INT(2) DEFAULT 0,
            `leaguecoefficient_season_id` INT(5) DEFAULT 0,
            `leaguecoefficient_team_id` INT(5) DEFAULT 0,
            `leaguecoefficient_win` INT(2) DEFAULT 0,
            `leaguecoefficient_win_bullet` INT(2) DEFAULT 0,
            `leaguecoefficient_win_over` INT(2) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `leaguecoefficient_country_id` ON `leaguecoefficient` (`leaguecoefficient_country_id`);';
$q[] = 'CREATE INDEX `leaguecoefficient_season_id` ON `leaguecoefficient` (`leaguecoefficient_season_id`);';
$q[] = 'CREATE INDEX `leaguecoefficient_team_id` ON `leaguecoefficient` (`leaguecoefficient_team_id`);';