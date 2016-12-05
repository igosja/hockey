<?php

$q = array();

$q[] = 'CREATE TABLE `statisticteam`
        (
            `statisticteam_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `statisticteam_championship_playoff` TINYINT(1) DEFAULT 0,
            `statisticteam_country_id` SMALLINT(3) DEFAULT 0,
            `statisticteam_division_id` TINYINT(2) DEFAULT 0,
            `statisticteam_game` TINYINT(2) DEFAULT 0,
            `statisticteam_game_no_pass` TINYINT(2) DEFAULT 0, #Игры без габитых голов
            `statisticteam_game_no_score` TINYINT(2) DEFAULT 0, #Игры без пропущенных голов
            `statisticteam_loose` TINYINT(2) DEFAULT 0,
            `statisticteam_loose_bullet` TINYINT(2) DEFAULT 0,
            `statisticteam_loose_over` TINYINT(2) DEFAULT 0,
            `statisticteam_national_id` SMALLINT(5) DEFAULT 0,
            `statisticteam_pass` TINYINT(2) DEFAULT 0,
            `statisticteam_penalty` TINYINT(2) DEFAULT 0,
            `statisticteam_penalty_opponent` TINYINT(2) DEFAULT 0,
            `statisticteam_score` TINYINT(2) DEFAULT 0,
            `statisticteam_season_id` SMALLINT(5) DEFAULT 0,
            `statisticteam_team_id` SMALLINT(5) DEFAULT 0,
            `statisticteam_tournamenttype_id` TINYINT(1) DEFAULT 0,
            `statisticteam_win` TINYINT(2) DEFAULT 0,
            `statisticteam_win_bullet` TINYINT(2) DEFAULT 0,
            `statisticteam_win_over` TINYINT(2) DEFAULT 0,
            `statisticteam_win_percent` TINYINT(2) DEFAULT 0 #Процент побед
        );';