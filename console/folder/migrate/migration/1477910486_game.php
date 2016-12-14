<?php

$q = array();

$q[] = 'CREATE TABLE `game`
        (
            `game_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `game_bonus_home` TINYINT(1) DEFAULT 1,
            `game_guest_auto` TINYINT(1) DEFAULT 0,
            `game_guest_collision_loose` TINYINT(1) DEFAULT 0,
            `game_guest_collision_win` TINYINT(1) DEFAULT 0,
            `game_guest_forecast` SMALLINT(4) DEFAULT 0,
            `game_guest_mood_id` TINYINT(1) DEFAULT 0,
            `game_guest_national_id` SMALLINT(5) DEFAULT 0,
            `game_guest_optimality` TINYINT(3) DEFAULT 0,
            `game_guest_penalty` TINYINT(2) DEFAULT 0,
            `game_guest_penalty_1` TINYINT(2) DEFAULT 0,
            `game_guest_penalty_2` TINYINT(2) DEFAULT 0,
            `game_guest_penalty_3` TINYINT(2) DEFAULT 0,
            `game_guest_penalty_over` TINYINT(2) DEFAULT 0,
            `game_guest_power` SMALLINT(4) DEFAULT 0,
            `game_guest_rude_id` TINYINT(1) DEFAULT 0,
            `game_guest_score` TINYINT(2) DEFAULT 0,
            `game_guest_score_1` TINYINT(2) DEFAULT 0,
            `game_guest_score_2` TINYINT(2) DEFAULT 0,
            `game_guest_score_3` TINYINT(2) DEFAULT 0,
            `game_guest_score_bullet` TINYINT(1) DEFAULT 0,
            `game_guest_score_over` TINYINT(1) DEFAULT 0,
            `game_guest_shot` TINYINT(2) DEFAULT 0,
            `game_guest_shot_1` TINYINT(2) DEFAULT 0,
            `game_guest_shot_2` TINYINT(2) DEFAULT 0,
            `game_guest_shot_3` TINYINT(2) DEFAULT 0,
            `game_guest_shot_over` TINYINT(2) DEFAULT 0,
            `game_guest_style_id` TINYINT(1) DEFAULT 0,
            `game_guest_tactic_id` TINYINT(1) DEFAULT 0,
            `game_guest_team_id` SMALLINT(5) DEFAULT 0,
            `game_guest_teamwork_1` DOUBLE(4,2) DEFAULT 0,
            `game_guest_teamwork_2` DOUBLE(4,2) DEFAULT 0,
            `game_guest_teamwork_3` DOUBLE(4,2) DEFAULT 0,
            `game_home_auto` TINYINT(0) DEFAULT 0,
            `game_home_collision_loose` TINYINT(1) DEFAULT 0,
            `game_home_collision_win` TINYINT(1) DEFAULT 0,
            `game_home_forecast` SMALLINT(4) DEFAULT 0,
            `game_home_mood_id` TINYINT(1) DEFAULT 0,
            `game_home_national_id` SMALLINT(5) DEFAULT 0,
            `game_home_optimality` TINYINT(3) DEFAULT 0,
            `game_home_penalty` TINYINT(2) DEFAULT 0,
            `game_home_penalty_1` TINYINT(2) DEFAULT 0,
            `game_home_penalty_2` TINYINT(2) DEFAULT 0,
            `game_home_penalty_3` TINYINT(2) DEFAULT 0,
            `game_home_penalty_over` TINYINT(2) DEFAULT 0,
            `game_home_power` SMALLINT(4) DEFAULT 0,
            `game_home_rude_id` TINYINT(1) DEFAULT 0,
            `game_home_score` TINYINT(2) DEFAULT 0,
            `game_home_score_1` TINYINT(2) DEFAULT 0,
            `game_home_score_2` TINYINT(2) DEFAULT 0,
            `game_home_score_3` TINYINT(2) DEFAULT 0,
            `game_home_score_bullet` TINYINT(1) DEFAULT 0,
            `game_home_score_over` TINYINT(1) DEFAULT 0,
            `game_home_shot` TINYINT(2) DEFAULT 0,
            `game_home_shot_1` TINYINT(2) DEFAULT 0,
            `game_home_shot_2` TINYINT(2) DEFAULT 0,
            `game_home_shot_3` TINYINT(2) DEFAULT 0,
            `game_home_shot_over` TINYINT(2) DEFAULT 0,
            `game_home_style_id` TINYINT(1) DEFAULT 0,
            `game_home_tactic_id` TINYINT(1) DEFAULT 0,
            `game_home_team_id` SMALLINT(5) DEFAULT 0,
            `game_home_teamwork_1` DOUBLE(4,2) DEFAULT 0,
            `game_home_teamwork_2` DOUBLE(4,2) DEFAULT 0,
            `game_home_teamwork_3` DOUBLE(4,2) DEFAULT 0,
            `game_played` TINYINT(1) DEFAULT 0,
            `game_ticket` TINYINT(2) DEFAULT 0,
            `game_stadium_capacity` SMALLINT(5) DEFAULT 0,
            `game_stadium_id` SMALLINT(5) DEFAULT 0,
            `game_shedule_id` INT(11) DEFAULT 0,
            `game_visitor` SMALLINT(5) DEFAULT 0
        );';