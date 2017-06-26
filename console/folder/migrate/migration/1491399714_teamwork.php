<?php

$q = array();

$q[] = 'CREATE TABLE `teamwork`
        (
            `teamwork_player_1_id` INT(11) DEFAULT 0,
            `teamwork_player_2_id` INT(11) DEFAULT 0,
            `teamwork_value` INT(3) DEFAULT 0
        );';