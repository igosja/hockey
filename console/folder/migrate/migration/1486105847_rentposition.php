<?php

$q = array();

$q[] = 'CREATE TABLE `rentposition`
        (
            `rentposition_position_id` INT(1) DEFAULT 0,
            `rentposition_rent_id` INT(11) DEFAULT 0
        );';