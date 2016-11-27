<?php

$q = array();

$q[] = 'CREATE TABLE `buildingstadium`
        (
            `buildingstadium_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `buildingstadium_capacity` SMALLINT(5) DEFAULT 0,
            `buildingstadium_constructiontype_id` TINYINT(1) DEFAULT 0,
            `buildingstadium_day` TINYINT(2) DEFAULT 0,
            `buildingstadium_team_id` SMALLINT(5) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `buildingstadium_day` ON `buildingstadium` (`buildingstadium_day`);';
$q[] = 'CREATE INDEX `buildingstadium_team_id` ON `buildingstadium` (`buildingstadium_team_id`);';