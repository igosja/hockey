<?php

$q = array();

$q[] = 'CREATE TABLE `forumtheme`
        (
            `forumtheme_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `forumtheme_count_message` INT(11) DEFAULT 0,
            `forumtheme_count_view` INT(11) DEFAULT 0,
            `forumtheme_date` INT(11) DEFAULT 0,
            `forumtheme_forumchapter_id` INT(11) DEFAULT 0,
            `forumtheme_last_date` INT(11) DEFAULT 0,
            `forumtheme_last_forummessage_id` INT(11) DEFAULT 0,
            `forumtheme_last_user_id` INT(11) DEFAULT 0,
            `forumtheme_name` VARCHAR(255),
            `forumtheme_user_id` INT(11) DEFAULT 0
        );';