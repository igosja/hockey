<?php

$q = array();

$q[] = 'CREATE TABLE `scout`
        (
            `scout_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `scout_percent` TINYINT(3) DEFAULT 0,
            `scout_player_id` INT(11) DEFAULT 0,
            `scout_ready` TINYINT(1) DEFAULT 0,
            `scout_season_id` TINYINT(2) DEFAULT 0,
            `scout_style` TINYINT(1) DEFAULT 0,
            `scout_team_id` SMALLINT(5) DEFAULT 0
        );';