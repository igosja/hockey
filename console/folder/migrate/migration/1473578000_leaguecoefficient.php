<?php

$q = array();

$q[] = 'CREATE TABLE `leaguecoefficient`
        (
            `leaguecoefficient_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `leaguecoefficient_country_id` INT(3) DEFAULT 0,
            `leaguecoefficient_season_id` INT(5) DEFAULT 0,
            `leaguecoefficient_team` INT(5) DEFAULT 0,
            `leaguecoefficient_value` INT(2) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `leaguecoefficient_country_id` ON `leaguecoefficient` (`leaguecoefficient_country_id`)';
$q[] = 'CREATE INDEX `leaguecoefficient_season_id` ON `leaguecoefficient` (`leaguecoefficient_season_id`)';