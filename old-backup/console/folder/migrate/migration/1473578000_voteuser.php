<?php

$q = array();

$q[] = 'CREATE TABLE `voteuser`
        (
            `voteuser_answer_id` INT(11) DEFAULT 0,
            `voteuser_date` INT(11) DEFAULT 0,
            `voteuser_user_id` INT(11) DEFAULT 0,
            `voteuser_vote_id` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `voteuser_user_id` ON `voteuser` (`voteuser_user_id`);';
$q[] = 'CREATE INDEX `voteuser_vote_id` ON `voteuser` (`voteuser_vote_id`);';