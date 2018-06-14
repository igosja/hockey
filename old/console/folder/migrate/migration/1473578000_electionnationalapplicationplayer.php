<?php

$q = array();

$q[] = 'CREATE TABLE `electionnationalapplicationplayer`
        (
            `electionnationalapplicationplayer_id` INT(1) PRIMARY KEY AUTO_INCREMENT,
            `electionnationalapplicationplayer_electionnationalapplication_id` INT(11) DEFAULT 0,
            `electionnationalapplicationplayer_player_id` INT(11)
        );';
$q[] = 'CREATE INDEX `electionnationalapplicationplayer_electionnationalapplication_id` ON `electionnationalapplicationplayer` (`electionnationalapplicationplayer_electionnationalapplication_id`);';