<?php

$q = array();

$q[] = 'CREATE TABLE `forummessage`
        (
            `forummessage_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `forummessage_date` INT(11) DEFAULT 0,
            `forummessage_forumtheme_id` INT(11) DEFAULT 0,
            `forummessage_text` TEXT NOT NULL,
            `forummessage_user_id` INT(11) DEFAULT 0
        );';