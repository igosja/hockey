<?php

$q = array();

$q[] = 'CREATE TABLE `onecomputer`
        (
            `onecomputer_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `onecomputer_child_id` INT(11) DEFAULT 0,
            `onecomputer_count` INT(11) DEFAULT 1,
            `onecomputer_date` INT(11) DEFAULT 0,
            `onecomputer_user_id` INT(11) DEFAULT 0
        );';