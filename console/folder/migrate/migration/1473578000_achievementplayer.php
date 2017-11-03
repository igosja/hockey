<?php

$q = array();

$q[] = 'CREATE TABLE `achievementplayer`
        (
            `achievementplayer_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `achievementplayer_country_id` INT(3) DEFAULT 0,
            `achievementplayer_division_id` INT(5) DEFAULT 0,
            `achievementplayer_is_playoff` INT(1) DEFAULT 0,
            `achievementplayer_national_id` INT(5) DEFAULT 0,
            `achievementplayer_player_id` INT(11) DEFAULT 0,
            `achievementplayer_position` INT(2) DEFAULT 0,
            `achievementplayer_season_id` INT(3) DEFAULT 0,
            `achievementplayer_stage_id` INT(2) DEFAULT 0,
            `achievementplayer_team_id` INT(5) DEFAULT 0,
            `achievementplayer_tournamenttype_id` INT(1) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `achievementplayer_player_id` ON `achievementplayer` (`achievementplayer_player_id`);';