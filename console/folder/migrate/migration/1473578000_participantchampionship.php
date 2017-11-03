<?php

$q = array();

$q[] = 'CREATE TABLE `participantchampionship`
        (
            `participantchampionship_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `participantchampionship_country_id` INT(3) DEFAULT 0,
            `participantchampionship_division_id` INT(2) DEFAULT 0,
            `participantchampionship_season_id` INT(3) DEFAULT 0,
            `participantchampionship_stage_id` INT(3) DEFAULT 0,
            `participantchampionship_stage_1` INT(1) DEFAULT 0,
            `participantchampionship_stage_2` INT(1) DEFAULT 0,
            `participantchampionship_stage_4` INT(1) DEFAULT 0,
            `participantchampionship_team_id` INT(5) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `participantchampionship_season_id` ON `participantchampionship` (`participantchampionship_season_id`);';