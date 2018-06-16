<?php

$q = array();

$q[] = 'CREATE TABLE `statisticteam`
        (
            `statisticteam_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `statisticteam_championship_playoff` INT(1) DEFAULT 0,
            `statisticteam_country_id` INT(3) DEFAULT 0,
            `statisticteam_division_id` INT(2) DEFAULT 0,
            `statisticteam_game` INT(2) DEFAULT 0,
            `statisticteam_game_no_pass` INT(2) DEFAULT 0, #Игры без забитых голов
            `statisticteam_game_no_score` INT(2) DEFAULT 0, #Игры без пропущенных голов
            `statisticteam_loose` INT(2) DEFAULT 0,
            `statisticteam_loose_bullet` INT(2) DEFAULT 0,
            `statisticteam_loose_over` INT(2) DEFAULT 0,
            `statisticteam_national_id` INT(5) DEFAULT 0,
            `statisticteam_pass` INT(2) DEFAULT 0,
            `statisticteam_penalty` INT(2) DEFAULT 0,
            `statisticteam_penalty_opponent` INT(2) DEFAULT 0,
            `statisticteam_score` INT(2) DEFAULT 0,
            `statisticteam_season_id` INT(5) DEFAULT 0,
            `statisticteam_team_id` INT(5) DEFAULT 0,
            `statisticteam_tournamenttype_id` INT(1) DEFAULT 0,
            `statisticteam_win` INT(2) DEFAULT 0,
            `statisticteam_win_bullet` INT(2) DEFAULT 0,
            `statisticteam_win_over` INT(2) DEFAULT 0,
            `statisticteam_win_percent` DECIMAL(5,2) DEFAULT 0 #Процент побед
        );';
$q[] = 'CREATE INDEX `statisticteam_championship_playoff` ON `statisticteam` (`statisticteam_championship_playoff`);';
$q[] = 'CREATE INDEX `statisticteam_country_id` ON `statisticteam` (`statisticteam_country_id`);';
$q[] = 'CREATE INDEX `statisticteam_division_id` ON `statisticteam` (`statisticteam_division_id`);';
$q[] = 'CREATE INDEX `statisticteam_national_id` ON `statisticteam` (`statisticteam_national_id`);';
$q[] = 'CREATE INDEX `statisticteam_season_id` ON `statisticteam` (`statisticteam_season_id`);';
$q[] = 'CREATE INDEX `statisticteam_tournamenttype_id` ON `statisticteam` (`statisticteam_tournamenttype_id`);';