<?php

$q = array();

$q[] = 'CREATE TABLE `team`
        (
            `team_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `team_base_id` INT(11) DEFAULT 1,
            `team_basemedical_id` INT(11) DEFAULT 1,
            `team_basephisical_id` INT(11) DEFAULT 1,
            `team_baseschool_id` INT(11) DEFAULT 1,
            `team_basescout_id` INT(11) DEFAULT 1,
            `team_basetraining_id` INT(11) DEFAULT 1,
            `team_finance` INT(11) DEFAULT 1000000,
            `team_name` VARCHAR(255) NOT NULL,
            `team_shop_position` INT(11) DEFAULT 0,
            `team_shop_special` INT(11) DEFAULT 0,
            `team_shop_training` INT(11) DEFAULT 0,
            `team_stadium_id` INT(11) DEFAULT 0,
            `team_vote_junior` INT(11) DEFAULT 2,
            `team_vote_national` INT(11) DEFAULT 2,
            `team_vote_president` INT(11) DEFAULT 2,
            `team_vote_youth` INT(11) DEFAULT 2
        );';
$q[] = 'CREATE INDEX `team_base_id` ON `team` (`team_base_id`);';
$q[] = 'CREATE INDEX `team_basemedical_id` ON `team` (`team_basemedical_id`);';
$q[] = 'CREATE INDEX `team_basephisical_id` ON `team` (`team_basephisical_id`);';
$q[] = 'CREATE INDEX `team_baseschool_id` ON `team` (`team_baseschool_id`);';
$q[] = 'CREATE INDEX `team_basescout_id` ON `team` (`team_basescout_id`);';
$q[] = 'CREATE INDEX `team_basetraining_id` ON `team` (`team_basetraining_id`);';
$q[] = 'CREATE INDEX `team_stadium_id` ON `team` (`team_stadium_id`);';