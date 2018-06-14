<?php

$q = array();

$q[] = 'CREATE TABLE `buildingstadium`
        (
            `buildingstadium_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `buildingstadium_capacity` INT(5) DEFAULT 0,
            `buildingstadium_constructiontype_id` INT(1) DEFAULT 0,
            `buildingstadium_day` INT(2) DEFAULT 0,
            `buildingstadium_ready` INT(1) DEFAULT 0,
            `buildingstadium_team_id` INT(5) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `buildingstadium_ready` ON `buildingstadium` (`buildingstadium_ready`);';
$q[] = 'CREATE INDEX `buildingstadium_team_id` ON `buildingstadium` (`buildingstadium_team_id`);';