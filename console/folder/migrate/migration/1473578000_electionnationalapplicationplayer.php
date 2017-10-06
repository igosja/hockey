<?php

$q = array();

$q[] = 'CREATE TABLE `electionnationalapplicationplayer`
        (
            `electionnationalapplicationplayer_id` INT(1) PRIMARY KEY AUTO_INCREMENT,
            `electionnationalapplicationplayer_electionnationalapplication_id` INT(11) DEFAULT 0,
            `electionnationalapplicationplayer_player_id` INT(11)
        );';