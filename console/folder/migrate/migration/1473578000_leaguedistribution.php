<?php

$q = array();

$q[] = 'CREATE TABLE `leaguedistribution`
        (
            `leaguedistribution_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `leaguedistribution_country_id` INT(3) DEFAULT 0,
            `leaguedistribution_group` INT(1) DEFAULT 0,
            `leaguedistribution_qualification_4` INT(1) DEFAULT 0,
            `leaguedistribution_qualification_3` INT(1) DEFAULT 0,
            `leaguedistribution_qualification_2` INT(1) DEFAULT 0,
            `leaguedistribution_qualification_1` INT(1) DEFAULT 0,
            `leaguedistribution_season_id` INT(5) DEFAULT 0
        );';
$q[] = 'INSERT INTO `leaguedistribution`
        (
            `leaguedistribution_country_id`,
            `leaguedistribution_group`,
            `leaguedistribution_qualification_3`,
            `leaguedistribution_qualification_2`,
            `leaguedistribution_qualification_1`,
            `leaguedistribution_season_id`
        )
        VALUES (71, 2, 1, 1, 0, 2),
               (133, 2, 1, 1, 0, 2),
               (157, 2, 1, 1, 0, 2),
               (185, 2, 1, 1, 0, 2),
               (18, 2, 1, 0, 1, 2),
               (43, 2, 1, 0, 1, 2),
               (122, 2, 1, 0, 1, 2),
               (151, 2, 1, 0, 1, 2),
               (171, 2, 1, 0, 1, 2),
               (176, 2, 1, 0, 1, 2),
               (182, 2, 1, 0, 1, 2),
               (184, 2, 1, 0, 1, 2);';