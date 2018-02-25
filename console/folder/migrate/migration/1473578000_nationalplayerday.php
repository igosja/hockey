<?php

$q = array();

$q[] = 'CREATE TABLE `nationalplayerday`
        (
            `nationalplayerday_day` INT(2) DEFAULT 0,
            `nationalplayerday_national_id` INT(11) DEFAULT 0,
            `nationalplayerday_player_id` INT(11) DEFAULT 0,
            `nationalplayerday_team_id` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `nationalplayerday_national_id` ON `nationalplayerday` (`nationalplayerday_national_id`)';