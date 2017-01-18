<?php

$q = array();

$q[] = 'CREATE TABLE `achievementplayer`
        (
            `achievementplayer_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `achievementplayer_country_id` SMALLINT(3) DEFAULT 0,
            `achievementplayer_division_id` SMALLINT(5) DEFAULT 0,
            `achievementplayer_is_playoff` TINYINT(1) DEFAULT 0,
            `achievementplayer_national_id` SMALLINT(5) DEFAULT 0,
            `achievementplayer_player_id` INT(11) DEFAULT 0,
            `achievementplayer_position` TINYINT(2) DEFAULT 0,
            `achievementplayer_season_id` TINYINT(3) DEFAULT 0,
            `achievementplayer_stage_id` TINYINT(2) DEFAULT 0,
            `achievementplayer_team_id` SMALLINT(5) DEFAULT 0,
            `achievementplayer_tournamenttype_id` TINYINT(1) DEFAULT 0,
            `achievementplayer_user_id` INT(11) DEFAULT 0
        );';