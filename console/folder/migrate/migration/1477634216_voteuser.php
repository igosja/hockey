<?php

$q = array();

$q[] = 'CREATE TABLE `voteuser`
        (
            `voteuser_answer_id` INT(11) DEFAULT 0,
            `voteuser_date` INT(11) DEFAULT 0,
            `voteuser_user_id` INT(11) DEFAULT 0,
            `voteuser_vote_id` INT(11) DEFAULT 0
        );';