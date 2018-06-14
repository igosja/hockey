<?php

$q = array();

$q[] = 'CREATE TABLE `team`
        (
            `team_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `team_age` DECIMAL(5,3) DEFAULT 0,
            `team_auto` INT(1) DEFAULT 0,
            `team_base_id` INT(2) DEFAULT 2,
            `team_basemedical_id` INT(2) DEFAULT 1,
            `team_basephisical_id` INT(2) DEFAULT 1,
            `team_baseschool_id` INT(2) DEFAULT 1,
            `team_basescout_id` INT(2) DEFAULT 1,
            `team_basetraining_id` INT(2) DEFAULT 1,
            `team_finance` INT(11) DEFAULT 10000000,
            `team_free_base` INT(1) DEFAULT 5,
            `team_mood_rest` INT(1) DEFAULT 3,
            `team_mood_super` INT(1) DEFAULT 3,
            `team_name` VARCHAR(255),
            `team_player` INT(3) DEFAULT 27,
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
$q[] = 'CREATE INDEX `team_stadium_id` ON `team` (`team_stadium_id`);';
$q[] = 'CREATE INDEX `team_user_id` ON `team` (`team_user_id`);';
$q[] = 'CREATE INDEX `team_vote_national` ON `team` (`team_vote_national`);';
$q[] = 'CREATE INDEX `team_vote_president` ON `team` (`team_vote_president`);';
$q[] = 'CREATE INDEX `team_vote_u19` ON `team` (`team_vote_u19`);';
$q[] = 'CREATE INDEX `team_vote_u21` ON `team` (`team_vote_u21`);';
$q[] = "INSERT INTO `team`
        SET `team_stadium_id`=0,
            `team_name`='Free team'";
$q[] = "UPDATE `team`
        SET `team_id`=0
        WHERE `team_id`=1
        LIMIT 1";
$q[] = "ALTER TABLE `team` AUTO_INCREMENT=1";