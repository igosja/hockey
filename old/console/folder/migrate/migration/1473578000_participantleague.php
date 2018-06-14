<?php

$q = array();

$q[] = 'CREATE TABLE `participantleague`
        (
            `participantleague_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `participantleague_season_id` INT(3) DEFAULT 0,
            `participantleague_stage_1` INT(1) DEFAULT 0,
            `participantleague_stage_2` INT(1) DEFAULT 0,
            `participantleague_stage_4` INT(1) DEFAULT 0,
            `participantleague_stage_8` INT(1) DEFAULT 0,
            `participantleague_stage_id` INT(3) DEFAULT 0,
            `participantleague_stage_in` INT(3) DEFAULT 0,
            `participantleague_team_id` INT(5) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `participantleague_season_id` ON `participantleague` (`participantleague_season_id`);';