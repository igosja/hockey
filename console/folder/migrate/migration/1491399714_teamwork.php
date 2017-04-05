<?php

$q = array();

$q[] = 'CREATE TABLE `teamwork`
        (
            `teamwork_player_id_1` INT(11) DEFAULT 0,
            `teamwork_player_id_2` INT(11) DEFAULT 0,
            `teamwork_value` TINYINT(3) DEFAULT 0
        );';