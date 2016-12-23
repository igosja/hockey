<?php

$q = array();

$q[] = 'CREATE TABLE `event`
        (
            `event_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `event_eventtextbullet_id` TINYINT(1) DEFAULT 0,
            `event_eventtextgoal_id` TINYINT(1) DEFAULT 0,
            `event_eventtextpenalty_id` TINYINT(2) DEFAULT 0,
            `event_eventtype_id` TINYINT(1) DEFAULT 0,
            `event_game_id` INT(11) DEFAULT 0,
            `event_guest_score` TINYINT(2) DEFAULT 0,
            `event_home_score` TINYINT(2) DEFAULT 0,
            `event_minute` TINYINT(2) DEFAULT 0,
            `event_national_id` SMALLINT(5) DEFAULT 0,
            `event_player_assist_1_id` INT(11) DEFAULT 0,
            `event_player_assist_2_id` INT(11) DEFAULT 0,
            `event_player_penalty_id` INT(11) DEFAULT 0,
            `event_player_score_id` INT(11) DEFAULT 0,
            `event_second` TINYINT(2) DEFAULT 0,
            `event_team_id` SMALLINT(5) DEFAULT 0
        );';