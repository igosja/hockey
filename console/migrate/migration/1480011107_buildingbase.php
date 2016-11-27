<?php

$q = array();

$q[] = 'CREATE TABLE `buildingbase`
        (
            `buildingbase_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `buildingbase_building_id` TINYINT(1) DEFAULT 0,
            `buildingbase_constructiontype_id` TINYINT(1) DEFAULT 0,
            `buildingbase_day` TINYINT(2) DEFAULT 0,
            `buildingbase_team_id` SMALLINT(5) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `buildingbase_day` ON `buildingbase` (`buildingbase_day`);';
$q[] = 'CREATE INDEX `buildingbase_team_id` ON `buildingbase` (`buildingbase_team_id`);';