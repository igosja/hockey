<?php

$q = array();

$q[] = 'CREATE TABLE `event`
        (
            `event_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `event_eventtextbullet_id` INT(1) DEFAULT 0,
            `event_eventtextgoal_id` INT(1) DEFAULT 0,
            `event_eventtextpenalty_id` INT(2) DEFAULT 0,
            `event_eventtype_id` INT(1) DEFAULT 0,
            `event_game_id` INT(11) DEFAULT 0,
            `event_guest_score` INT(2) DEFAULT 0,
            `event_home_score` INT(2) DEFAULT 0,
            `event_minute` INT(2) DEFAULT 0,
            `event_national_id` INT(5) DEFAULT 0,
            `event_player_assist_1_id` INT(11) DEFAULT 0,
            `event_player_assist_2_id` INT(11) DEFAULT 0,
            `event_player_penalty_id` INT(11) DEFAULT 0,
            `event_player_score_id` INT(11) DEFAULT 0,
            `event_second` INT(2) DEFAULT 0,
            `event_team_id` INT(5) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `event_game_id` ON `event` (`event_game_id`);';