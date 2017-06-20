<?php

$q = array();

$q[] = 'CREATE TABLE `forumchapter`
        (
            `forumchapter_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `forumchapter_count_message` INT(11) DEFAULT 0,
            `forumchapter_count_theme` INT(11) DEFAULT 0,
            `forumchapter_description` TEXT NOT NULL,
            `forumchapter_forumgroup_id` INT(11) DEFAULT 0,
            `forumchapter_last_date` INT(11) DEFAULT 0,
            `forumchapter_last_forummessage_id` INT(11) DEFAULT 0,
            `forumchapter_last_forumtheme_id` INT(11) DEFAULT 0,
            `forumchapter_last_user_id` INT(11) DEFAULT 0,
            `forumchapter_name` VARCHAR(255) NOT NULL,
            `forumchapter_order` SMALLINT(3) DEFAULT 0,
            `forumchapter_user_id` INT(11) DEFAULT 0
        );';