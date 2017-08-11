<?php

$q = array();

$q[] = 'CREATE TABLE `voteanswer`
        (
            `voteanswer_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `voteanswer_text` TEXT NOT NULL,
            `voteanswer_vote_id` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `voteanswer_vote_id` ON `voteanswer` (`voteanswer_vote_id`);';