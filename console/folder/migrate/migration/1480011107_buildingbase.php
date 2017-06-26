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