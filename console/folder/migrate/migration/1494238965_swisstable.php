<?php

$q = array();

$q[] = 'CREATE TABLE `swisstable`
        (
            `swisstable_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `swisstable_guest` INT(11) DEFAULT 0,
            `swisstable_home` INT(11) DEFAULT 0,
            `swisstable_place` INT(11) DEFAULT 0,
            `swisstable_team_id` INT(11) DEFAULT 0
        );';