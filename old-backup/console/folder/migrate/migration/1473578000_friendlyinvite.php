<?php

$q = array();

$q[] = 'CREATE TABLE `friendlyinvite`
        (
            `friendlyinvite_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `friendlyinvite_date` INT(11) DEFAULT 0,
            `friendlyinvite_friendlyinvitestatus_id` INT(1) DEFAULT 1,
            `friendlyinvite_friendlystatus_id` INT(1) DEFAULT 0,
            `friendlyinvite_guest_team_id` INT(11) DEFAULT 0,
            `friendlyinvite_guest_user_id` INT(11) DEFAULT 0,
            `friendlyinvite_home_team_id` INT(11) DEFAULT 0,
            `friendlyinvite_home_user_id` INT(11) DEFAULT 0,
            `friendlyinvite_schedule_id` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `friendlyinvite_home_team_id` ON `friendlyinvite` (`friendlyinvite_home_team_id`);';
$q[] = 'CREATE INDEX `friendlyinvite_guest_team_id` ON `friendlyinvite` (`friendlyinvite_guest_team_id`);';
$q[] = 'CREATE INDEX `friendlyinvite_schedule_id` ON `friendlyinvite` (`friendlyinvite_schedule_id`);';