<?php

$q = array();

$q[] = 'CREATE TABLE `transferspecial`
        (
            `transferspecial_level` INT(1) DEFAULT 0,
            `transferspecial_special_id` INT(2) DEFAULT 0,
            `transferspecial_transfer_id` INT(11) DEFAULT 0
        );';