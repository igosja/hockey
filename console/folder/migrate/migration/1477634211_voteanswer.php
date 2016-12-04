<?php

$q = array();

$q[] = 'CREATE TABLE `voteanswer`
        (
            `voteanswer_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `voteanswer_text` TEXT NOT NULL,
            `voteanswer_vote_id` INT(11) DEFAULT 0
        );';