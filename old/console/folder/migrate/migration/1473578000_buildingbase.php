<?php

$q = array();

$q[] = 'CREATE TABLE `buildingbase`
        (
            `buildingbase_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `buildingbase_building_id` INT(1) DEFAULT 0,
            `buildingbase_constructiontype_id` INT(1) DEFAULT 0,
            `buildingbase_day` INT(2) DEFAULT 0,
            `buildingbase_ready` INT(1) DEFAULT 0,
            `buildingbase_team_id` INT(5) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `buildingbase_ready` ON `buildingbase` (`buildingbase_ready`);';
$q[] = 'CREATE INDEX `buildingbase_team_id` ON `buildingbase` (`buildingbase_team_id`);';