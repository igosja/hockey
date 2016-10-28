<?php

$q = array();

$q[] = 'CREATE TABLE `team`
        (
            `team_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `team_base_id` TINYINT(2) DEFAULT 2,
            `team_basemedical_id` TINYINT(2) DEFAULT 1,
            `team_basephisical_id` TINYINT(2) DEFAULT 1,
            `team_baseschool_id` TINYINT(2) DEFAULT 1,
            `team_basescout_id` TINYINT(2) DEFAULT 1,
            `team_basetraining_id` TINYINT(2) DEFAULT 1,
            `team_finance` INT(11) DEFAULT 1000000,
            `team_name` VARCHAR(255) NOT NULL,
            `team_shop_position` TINYINT(3) DEFAULT 0,
            `team_shop_special` TINYINT(3) DEFAULT 0,
            `team_shop_training` TINYINT(3) DEFAULT 0,
            `team_stadium_id` INT(11) DEFAULT 0,
            `team_user_id` INT(11) DEFAULT 0,
            `team_vice_id` INT(11) DEFAULT 0,
            `team_vote_junior` TINYINT(1) DEFAULT 2,
            `team_vote_national` TINYINT(1) DEFAULT 2,
            `team_vote_president` TINYINT(1) DEFAULT 2,
            `team_vote_youth` TINYINT(1) DEFAULT 2
        );';
$q[] = 'CREATE INDEX `team_base_id` ON `team` (`team_base_id`);';
$q[] = 'CREATE INDEX `team_basemedical_id` ON `team` (`team_basemedical_id`);';
$q[] = 'CREATE INDEX `team_basephisical_id` ON `team` (`team_basephisical_id`);';
$q[] = 'CREATE INDEX `team_baseschool_id` ON `team` (`team_baseschool_id`);';
$q[] = 'CREATE INDEX `team_basescout_id` ON `team` (`team_basescout_id`);';
$q[] = 'CREATE INDEX `team_basetraining_id` ON `team` (`team_basetraining_id`);';
$q[] = 'CREATE INDEX `team_stadium_id` ON `team` (`team_stadium_id`);';
$q[] = 'CREATE INDEX `team_user_id` ON `team` (`team_user_id`);';
$q[] = 'CREATE INDEX `team_vice_id` ON `team` (`team_vice_id`);';