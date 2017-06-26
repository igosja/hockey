<?php

$q = array();

$q[] = 'CREATE TABLE `team`
        (
            `team_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `team_base_id` INT(2) DEFAULT 2,
            `team_basemedical_id` INT(2) DEFAULT 1,
            `team_basephisical_id` INT(2) DEFAULT 1,
            `team_baseschool_id` INT(2) DEFAULT 1,
            `team_basescout_id` INT(2) DEFAULT 1,
            `team_basetraining_id` INT(2) DEFAULT 1,
            `team_finance` INT(11) DEFAULT 1000000,
            `team_name` VARCHAR(255) NOT NULL,
            `team_power_c_16` INT(5) DEFAULT 0,
            `team_power_c_21` INT(5) DEFAULT 0,
            `team_power_c_27` INT(5) DEFAULT 0,
            `team_power_s_16` INT(5) DEFAULT 0,
            `team_power_s_21` INT(5) DEFAULT 0,
            `team_power_s_27` INT(5) DEFAULT 0,
            `team_power_v` INT(5) DEFAULT 0,
            `team_power_vs` INT(5) DEFAULT 0,
            `team_price_base` INT(11) DEFAULT 0,
            `team_price_player` INT(11) DEFAULT 0,
            `team_price_stadium` INT(11) DEFAULT 0,
            `team_price_total` INT(11) DEFAULT 0,
            `team_salary` INT(6) DEFAULT 0,
            `team_stadium_id` INT(11) DEFAULT 0,
            `team_user_id` INT(11) DEFAULT 0,
            `team_vice_id` INT(11) DEFAULT 0,
            `team_visitor` INT(3) DEFAULT 100,
            `team_vote_national` INT(1) DEFAULT 2,
            `team_vote_president` INT(1) DEFAULT 2,
            `team_vote_u19` INT(1) DEFAULT 2,
            `team_vote_u21` INT(1) DEFAULT 2
        );';