<?php

$q = array();

$q[] = 'CREATE TABLE `transferposition`
        (
            `transferposition_position_id` TINYINT(1) DEFAULT 0,
            `transferposition_transfer_id` INT(11) DEFAULT 0
        );';