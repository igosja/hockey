<?php

$q = array();

$q[] = 'CREATE TABLE `forumgroup`
        (
            `forumgroup_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `forumgroup_name` VARCHAR(255) NOT NULL,
            `forumgroup_order` INT(3) DEFAULT 0
        );';