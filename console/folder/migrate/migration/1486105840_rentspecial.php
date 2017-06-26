<?php

$q = array();

$q[] = 'CREATE TABLE `rentspecial`
        (
            `rentspecial_level` INT(1) DEFAULT 0,
            `rentspecial_rent_id` INT(11) DEFAULT 0,
            `rentspecial_special_id` INT(2) DEFAULT 0
        );';