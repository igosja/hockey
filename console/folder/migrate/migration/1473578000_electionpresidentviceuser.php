<?php

$q = array();

$q[] = 'CREATE TABLE `electionpresidentviceuser`
        (
            `electionpresidentviceuser_date` INT(11) DEFAULT 0,
            `electionpresidentviceuser_electionpresidentvice_id` INT(11) DEFAULT 0,
            `electionpresidentviceuser_electionpresidentviceapplication_id` INT(11) DEFAULT 0,
            `electionpresidentviceuser_user_id` INT(11) DEFAULT 0
        );';