<?php

$q = array();

$q[] = 'CREATE TABLE `friendlyinvite`
        (
            `friendlyinvite_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `friendlyinvite_date` INT(11) DEFAULT 0,
            `friendlyinvite_friendlystatus_id` INT(1) DEFAULT 0,
            `friendlyinvite_guest_team_id` INT(11) DEFAULT 0,
            `friendlyinvite_guest_user_id` INT(11) DEFAULT 0,
            `friendlyinvite_home_team_id` INT(11) DEFAULT 0,
            `friendlyinvite_home_user_id` INT(11) DEFAULT 0,
            `friendlyinvite_shedule_id` INT(11) DEFAULT 0,
            `friendlyinvite_status` INT(1) DEFAULT 0
        );';